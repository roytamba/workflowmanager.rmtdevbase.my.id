<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'client_name',
        'logo',
        'status',
        'budget',
        'total_tasks',
        'start_date',
        'end_date',
        'progress',
        'description',
        'created_by'
    ];
}
