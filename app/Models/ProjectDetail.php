<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_type',
        'status',
        'start_date',
        'end_date',
        'deployment_status',
        'uat_link',
        'live_link',
        'checkout_link',
        'image',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(
            Project::class,         // Model yang dihubungkan
            'project_id',          // Foreign key di tabel project_details
            'id'                   // Local key di tabel projects
        );
    }
}
