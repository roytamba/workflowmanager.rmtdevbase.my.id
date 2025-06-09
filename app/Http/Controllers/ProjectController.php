<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use App\Services\ProjectService;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $projects = $this->projectService->getAllProjects();
        $clients = Client::all();
        return view('project.index', compact('projects', 'clients'));
    }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt(urldecode($encryptedId));
            $project = $this->getProjectById($id);

            if (!$project) {
                return response()->json(['message' => 'Project not found.'], 404);
            }

            return view('project.components.show', compact('project'));
        } catch (DecryptException $e) {
            return abort(400, 'Invalid project ID.');
        }
    }

    public function getProjectById($projectId)
    {
        $project = Project::findOrFail($projectId);
        $maxVisible = 1;

        // Ambil semua anggota tim terkait project
        $teamMembers = DB::table('user_projects as up')
            ->join('users as u', 'u.id', '=', 'up.user_id')
            ->join('user_roles as ur', 'ur.user_id', '=', 'u.id')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->join('role_types as rt', 'rt.id', '=', 'r.role_type_id')
            ->leftJoin('user_details as ud', 'ud.user_id', '=', 'u.id')
            ->select('u.id as user_id', 'u.name as user_name', 'rt.name as role_type', 'ud.image')
            ->where('up.project_id', $project->id)
            ->get();

        // Kelompokkan berdasarkan role_type
        $project->project_managers = $teamMembers->where('role_type', 'Project Management')->values();
        $project->developers = $teamMembers->where('role_type', 'Software Developer')->values();
        $project->consultants = $teamMembers->where('role_type', 'Consulting')->values();
        $project->admins = $teamMembers->where('role_type', 'Administration')->values();

        // Hitung total anggota & yang ditampilkan
        $totalMembers = $project->project_managers->count();
        $totalDevelopers = $project->developers->count();
        $totalConsultants = $project->consultants->count();
        $totalAdmins = $project->admins->count();

        $total = $totalMembers + $totalDevelopers + $totalConsultants + $totalAdmins;
        $totalDisplayed =
            min($maxVisible, $totalMembers) +
            min($maxVisible, $totalDevelopers) +
            min($maxVisible, $totalConsultants) +
            min($maxVisible, $totalAdmins);
        $remaining = $total - $totalDisplayed;

        // Simpan ke dalam properti tambahan
        $project->max_visible = $maxVisible;
        $project->total_members = $total;
        $project->total_displayed = $totalDisplayed;
        $project->remaining_members = $remaining;

        return $project;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deployment_status' => 'required|in:none,uat,live',
            'uat_link' => 'nullable|url',
            'live_link' => 'nullable|url',
            'checkout_link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:in_progress,completed,on_hold,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('validation_errors', $validator->errors()->all())
                ->withInput();
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('projects/images', 'public');
            }

            Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'deployment_status' => $request->deployment_status,
                'uat_link' => $request->uat_link,
                'live_link' => $request->live_link,
                'checkout_link' => $request->checkout_link,
                'status' => $request->status,
                'created_by' => Auth::id(),
                'image' => $imagePath,
            ]);

            return redirect()->route('projects.index')
                ->with('success', 'Project created successfully!');
        } catch (Exception $e) {
            Log::error('Project creation failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to create project: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Project $project)
    {
        $users = User::select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        $project->load('teamMembers');

        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:In Progress,Completed,On Hold,Cancelled',
            'budget' => 'required|numeric|min:0',
            'total_tasks' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
            'team_members' => 'nullable|array',
            'team_members.*' => 'exists:users,id',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'name' => $request->name,
                'client_name' => $request->client_name,
                'status' => $request->status,
                'budget' => $request->budget,
                'total_tasks' => $request->total_tasks ?? 0,
                'start_date' => $request->start_date,
                'deadline' => $request->deadline,
                'progress' => $request->progress ?? 0,
                'description' => $request->description
            ];

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($project->logo && Storage::disk('public')->exists($project->logo)) {
                    Storage::disk('public')->delete($project->logo);
                }
                $updateData['logo'] = $request->file('logo')->store('projects/logos', 'public');
            }

            $project->update($updateData);

            // Sync team members
            if ($request->has('team_members')) {
                $teamData = [];
                foreach ($request->team_members as $userId) {
                    $teamData[$userId] = [
                        'joined_at' => now(),
                        'role' => 'member'
                    ];
                }
                $project->teamMembers()->sync($teamData);
            } else {
                $project->teamMembers()->detach();
            }

            return redirect()->route('projects.index')
                ->with('success', 'Project updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update project: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Project $project)
    {
        try {
            // Delete logo file if exists
            if ($project->logo && Storage::disk('public')->exists($project->logo)) {
                Storage::disk('public')->delete($project->logo);
            }

            // Detach team members
            $project->teamMembers()->detach();

            // Soft delete project
            $project->delete();

            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    // API methods for AJAX requests
    public function getProjectsByStatus($status)
    {
        $projects = Project::byStatus($status)
            ->with(['teamMembers', 'creator'])
            ->get();

        return response()->json($projects);
    }

    public function updateProgress(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'progress' => 'required|integer|min:0|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $project->update(['progress' => $request->progress]);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'progress' => $project->progress
        ]);
    }
}
