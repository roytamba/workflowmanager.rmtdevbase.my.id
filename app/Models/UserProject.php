<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = 'user_projects';
    protected $fillable = [
        'project_id',
        'user_id'
    ];
}
