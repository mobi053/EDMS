<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = [
        'name', 
        'class_name',
        'class_id', 
        'capacity', 
        'campus_name',
        'campus_id',
        'teacher_in_charge_name',
        'teacher_in_charge_id',
        'is_deleted'
    ];

    // Relationship: A section belongs to a class
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campuse_id');
    }
}
