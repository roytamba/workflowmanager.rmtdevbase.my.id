<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDesignation extends Model
{
    use HasFactory;

    protected $table = 'user_designations';

    protected $fillable = [
        'user_id',
        'role_id',
        'position_id',
        'status',
    ];

    // Relasi manual ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi manual ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi manual ke Position
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
