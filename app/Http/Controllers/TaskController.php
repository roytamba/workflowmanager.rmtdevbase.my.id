<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function iconTask()
    {
        $tagIcons = [
            'bug' => 'fa-bug',
            'enhancement' => 'fa-wrench',
            'change_request' => 'fa-retweet',
            'feature' => 'fa-lightbulb',
            'urgent' => 'fa-clock',
            'documentation' => 'fa-book',
            'design' => 'fa-paint-brush',
        ];

        return $tagIcons;
    
    }
    public function index()
    {
        $tasks = $this->taskService->getTasks();
        // dd($tasks);
        $projects = Project::all();
        $users = User::all();
        $tagIcons = $this->iconTask();
        return view('task.index', compact('projects', 'users', 'tagIcons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'module'         => 'nullable|string|max:255',
            'project_id'     => 'nullable|exists:projects,id',
            'assigned_to'    => 'nullable|exists:users,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'description'    => 'nullable|string',
            'start_date'     => 'nullable|date',
            'due_date'       => 'nullable|date',
            'completed_at'   => 'nullable|date',
            'status'         => 'required|in:not_started,in_progress,completed,on_hold,cancelled',
            'priority'       => 'required|in:low,medium,high,urgent',
            'is_approved'    => 'nullable|boolean',
            'notes'          => 'nullable|string',
            'tags'           => 'nullable|array',
            'tags.*'         => 'string|max:50',
            'attachments.*'  => 'nullable|file|max:5120',
        ]);

        $task = Task::create([
            'title'          => $validated['title'],
            'module'         => $validated['module'] ?? null,
            'project_id'     => $validated['project_id'] ?? null,
            'assigned_to'    => $validated['assigned_to'] ?? null,
            'parent_task_id' => $validated['parent_task_id'] ?? null,
            'description'    => $validated['description'] ?? null,
            'start_date'     => $validated['start_date'] ?? null,
            'due_date'       => $validated['due_date'] ?? null,
            'completed_at'   => $validated['completed_at'] ?? null,
            'status'         => $validated['status'], // Enum string (langsung disimpan)
            'priority'       => $validated['priority'],
            'is_approved'    => $validated['is_approved'] ?? false,
            'notes'          => $validated['notes'] ?? null,
            'tags'           => isset($validated['tags']) ? implode(',', $validated['tags']) : null,
            'created_by'     => Auth::user()->id,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $task->attachments()->create([
                    'file_path'   => $path,
                    'file_name'   => $file->getClientOriginalName(),
                    'file_size'   => $file->getSize(),
                    'file_type'   => $file->getClientMimeType(),
                    'uploaded_by' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Task created successfully.');
    }



    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'module'         => 'nullable|string|max:255',
            'project_id'     => 'nullable|exists:projects,id',
            'assigned_to'    => 'nullable|exists:users,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'description'    => 'nullable|string',
            'start_date'     => 'nullable|date',
            'due_date'       => 'nullable|date',
            'completed_at'   => 'nullable|date',
            'status'         => 'required|in:not_started,in_progress,completed,on_hold,cancelled',
            'priority'       => 'required|in:low,medium,high,urgent',
            'is_approved'    => 'nullable|boolean',
            'notes'          => 'nullable|string',
            'tags'           => 'nullable|array',
            'tags.*'         => 'string|max:50',
            'attachments.*'  => 'nullable|file|max:5120',
        ]);

        // dd($validated['module']);

        $task->update([
            'title'          => $validated['title'],
            'module'         => $validated['module'] ?? null,
            'project_id'     => $validated['project_id'] ?? null,
            'assigned_to'    => $validated['assigned_to'] ?? null,
            'parent_task_id' => $validated['parent_task_id'] ?? null,
            'description'    => $validated['description'] ?? null,
            'start_date'     => $validated['start_date'] ?? null,
            'due_date'       => $validated['due_date'] ?? null,
            'completed_at'   => $validated['completed_at'] ?? null,
            'status'         => $validated['status'],
            'priority'       => $validated['priority'],
            'is_approved'    => $validated['is_approved'] ?? false,
            'notes'          => $validated['notes'] ?? null,
            'tags'           => isset($validated['tags']) ? implode(',', $validated['tags']) : null,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $task->attachments()->create([
                    'file_path'   => $path,
                    'file_name'   => $file->getClientOriginalName(),
                    'file_size'   => $file->getSize(),
                    'file_type'   => $file->getClientMimeType(),
                    'uploaded_by' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Task updated successfully.');
    }


    public function destroy($id)
    {
        $task = Task::with('attachments')->findOrFail($id);

        // Hapus file dari storage
        foreach ($task->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            $attachment->delete();
        }

        // Soft delete task
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function getTagsAttribute($value)
    {
        // Jika sudah array, kembalikan langsung
        if (is_array($value)) {
            return $value;
        }

        // Jika null atau tidak bisa didecode, kembalikan array kosong
        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
