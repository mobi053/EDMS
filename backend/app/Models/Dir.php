<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dir extends Model
{
    use HasFactory;

    protected $table = 'dir';

    // Specify which attributes can be mass-assigned
    protected $fillable = [
        'title',
        'lead_id',
        'observation_id',
        'dir_number',
        'camera_id',
        'finding_status',
        'finding_remarks',
        'created_by',
        'department_id',
        'local_cameras_status',
        'total_cameras',
        'dir_status',
        'dir_date',
        'is_deleted',
    ];
}
