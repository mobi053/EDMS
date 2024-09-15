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
        'class_id', 
        'capacity', 
        'teacher_in_charge',
        'teacher_in_charge_id',
         'status'
    ];

    // Relationship: A section belongs to a class
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
