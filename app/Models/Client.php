<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(
            Project::class,         // Model yang dihubungkan
            'project_clients',      // Nama tabel pivot
            'client_id',            // Foreign key untuk model ini di tabel pivot
            'project_id',           // Foreign key untuk model Project di tabel pivot
            'id',                   // Local key di tabel clients
            'id'                    // Local key di tabel projects
        )->withPivot('status')      // Mengambil kolom tambahan dari tabel pivot
            ->withTimestamps();     // Mengambil created_at dan updated_at dari tabel pivot
    }

    /**
     * SCOPE CONTOH - untuk filter client aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
