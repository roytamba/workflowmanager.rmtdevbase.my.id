<?php

namespace App\Services;

use App\Models\ProjectDetail;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Ambil semua task beserta relasinya
     */
    public function getTasks()
    {
        try {
            $tasks = Task::all();
            dd($tasks);

            return $tasks->map(function ($task) {
                $maps = array_merge(
                    $this->mapTask($task),
                    $this->mapProjectBasic($task),
                    $this->mapAssignedUser($task),
                    $this->mapCreatedBy($task),
                    $this->mapParentTask($task)
                );
                return $maps;
            });
        } catch (Exception $e) {
            Log::error('Error in getTasks: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return collect([
                'error' => true,
                'message' => 'Failed to fetch tasks',
                'details' => app()->isLocal() ? $e->getMessage() : 'Internal server error'
            ]);
        }
    }

    /**
     * Ambil satu task berdasarkan ID
     */
    public function getTaskById($id)
    {
        try {
            $task = Task::with(['project', 'assignedUser', 'createdBy', 'parentTask'])->findOrFail($id);

            return array_merge(
                $this->mapTask($task),
                $this->mapProjectBasic($task),
                $this->mapProjectDetail($task),
                $this->mapAssignedUser($task),
                $this->mapCreatedBy($task),
                $this->mapParentTask($task)
            );
        } catch (Exception $e) {
            Log::error("Error in getTaskById (ID: $id): " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'error' => true,
                'message' => 'Failed to fetch task',
                'details' => app()->isLocal() ? $e->getMessage() : 'Internal server error'
            ];
        }
    }

    /**
     * Mapping data utama task
     */
    protected function mapTask($task)
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'module' => $task->module,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'completed_at' => $task->completed_at,
            'status' => $task->status,
            'priority' => $task->priority,
            'tags' => $task->tags,
            'selected_tags' => $this->parseTags($task->tags),
            'is_approved' => $task->is_approved,
            'notes' => $task->notes,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
        ];
    }

    /**
     * Mapping relasi project
     */
    protected function mapProjectBasic($task)
    {
        $project = Task::findOrFail($task->project_id);
        return [
            'has_project' => !is_null($project),
            'project_id' => $project->id,
            'project_name' => $project->name,
            'project_code' => $project->code,
            'project_description' => $project->description,
            'project_created_by' => $project->created_by,
            'project_created_at' => $project->created_at,
        ];
    }

    /**
     * Mapping relasi project details
     */

    protected function mapProjectDetail($task)
    {
        $projectDetail = ProjectDetail::where('project_id', $task->project_id)->firstOrFail();
        return [
            'project_detail_has_detail' => !is_null($projectDetail),
            'project_detail_id' => $projectDetail->id,
            'project_detail_type' => $projectDetail->project_type,
            'project_detail_status' => $projectDetail->status,
            'project_detail_start_date' => $projectDetail->start_date,
            'project_detail_end_date' => $projectDetail->end_date,
            'project_detail_deployment_status' => $projectDetail->deployment_status,
            'project_detail_has_uat_link' => !is_null($projectDetail->uat_link),
            'project_detail_has_live_link' => !is_null($projectDetail->live_link),
            'project_detail_has_checkout_link' => !is_null($projectDetail->checkout_link),
            'project_detail_uat_link' => $projectDetail->uat_link,
            'project_detail_live_link' => $projectDetail->live_link,
            'project_detail_checkout_link' => $projectDetail->checkout_link,
            'project_detail_has_image' => !is_null($projectDetail->image),
            'project_detail_image' => $projectDetail->image,
        ];
    }


    /**
     * Mapping user yang ditugaskan
     */
    protected function mapAssignedUser($task)
    {
        $user = $task->assignedUser;
        return [
            'assigned_user' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ] : null,
        ];
    }

    /**
     * Mapping user pembuat task
     */
    protected function mapCreatedBy($task)
    {
        $creator = $task->createdBy;
        return [
            'created_by' => $creator ? [
                'id' => $creator->id,
                'name' => $creator->name,
                'email' => $creator->email,
            ] : null,
        ];
    }

    /**
     * Mapping parent task (jika merupakan subtask)
     */
    protected function mapParentTask($task)
    {
        $parent = $task->parentTask;
        return [
            'parent_task' => $parent ? [
                'id' => $parent->id,
                'title' => $parent->title,
                'status' => $parent->status,
            ] : null,
        ];
    }

    /**
     * Parse string tag jadi array
     */
    protected function parseTags($tags)
    {
        if (!$tags) return [];
        return array_map('trim', explode(',', $tags));
    }
}
