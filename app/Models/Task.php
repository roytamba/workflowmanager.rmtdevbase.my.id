<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'module',
        'assigned_to',
        'created_by',
        'parent_task_id',
        'title',
        'description',
        'start_date',
        'due_date',
        'completed_at',
        'status',
        'priority',
        'progress',
        'attachment',
        'is_approved',
        'notes',
        'tags',
    ];

    /**
     * Casts
     * Otomatis decode JSON ke array dan sebaliknya
     */
    protected $casts = [
        'tags' => 'array',
    ];

    // ===== Relasi =====

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id', 'id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id', 'id');
    }

    /**
     * Scope untuk menyaring task aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'completed')->whereNull('deleted_at');
    }
}
