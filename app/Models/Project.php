<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'code',
        'description',
        'created_by',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(
            ProjectDetail::class,   // Model yang dihubungkan
            'project_id',           // Foreign key di tabel project_details
            'id'                    // Local key di tabel projects (primary key)
        );
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(
            Client::class,          // Model yang dihubungkan
            'project_clients',      // Nama tabel pivot
            'project_id',           // Foreign key untuk model ini di tabel pivot
            'client_id',            // Foreign key untuk model Client di tabel pivot
            'id',                   // Local key di tabel projects
            'id'                    // Local key di tabel clients
        )->withPivot('status')      // Mengambil kolom tambahan dari tabel pivot
            ->withTimestamps();     // Mengambil created_at dan updated_at dari tabel pivot
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'project_id', 'id');
    }
}
