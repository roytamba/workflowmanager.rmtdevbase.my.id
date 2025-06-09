<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'description',
        'created_by',
        'deployment_status',
        'uat_link',
        'live_link',
        'checkout_link',
        'image',
        'status',
    ];
}
