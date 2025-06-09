<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
