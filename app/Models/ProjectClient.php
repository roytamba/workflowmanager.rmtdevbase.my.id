<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectClient extends Model
{
    protected $table = 'project_clients';
    protected $fillable = [
        'project_id',
        'client_id',
        'status'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(
            Project::class,        // Model yang dihubungkan
            'project_id',          // Foreign key di tabel project_clients
            'id'                   // Local key di tabel projects
        );
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(
            Client::class,         // Model yang dihubungkan
            'client_id',           // Foreign key di tabel project_clients
            'id'                   // Local key di tabel clients
        );
    }
}
