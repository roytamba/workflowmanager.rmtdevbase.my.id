<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    protected array $statusLabels = [
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'on_hold' => 'On Hold',
        'cancelled' => 'Cancelled',
    ];

    public function getAllProjects()
    {
        return Project::all()->map(function ($project) {
            $project->status = $this->statusLabels[$project->status] ?? 'Not Set';
            $project->image = 'storage/' . $project->image;
            return $project;
        });
    }
}
