<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use App\Services\ProjectService;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            $project = $this->projectService->getProjectById($id);

            if (!$project) {
                return redirect()->back()->with('message', 'Project Not Found.');
            }

            return view('project.components.show', compact('project'));
        } catch (DecryptException $e) {
            return abort(400, 'Invalid project ID.');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:projects,code',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('validation_errors', $validator->errors()->all())
                ->withInput();
        }

        try {
            Project::create([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'created_by' => Auth::id(),
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

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:projects,code,' . $project->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('validation_errors', $validator->errors()->all())
                ->withInput();
        }

        try {
            $project->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'updated_by' => Auth::id(),
            ]);

            return redirect()->back()
                ->with('success', 'Project updated successfully!');
        } catch (Exception $e) {
            Log::error('Project update failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to update project: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);

            $project->delete();

            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully!');
        } catch (ModelNotFoundException $e) {
            Log::warning('Project not found for deletion: ID ' . $id);

            return redirect()->route('projects.index')
                ->with('error', 'Project not found.');
        } catch (Exception $e) {
            Log::error('Project deletion failed: ' . $e->getMessage());

            return redirect()->route('projects.index')
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
