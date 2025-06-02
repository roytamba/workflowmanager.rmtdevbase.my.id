<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $table = 'user_details';
    protected $fillable = [
        'user_id',
        'phone',
        'website',
        'position',
        'address',
        'language',
        'bio',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
