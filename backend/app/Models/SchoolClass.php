<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $fillable = [
        'name', 
        'teacher_in_charge_name', 
        'teacher_in_charge_id',
        'school_id',
        'status'
    ];
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    // Relationship: A class belongs to a school
    // public function school()
    // {
    //     return $this->belongsTo(School::class, 'school_id');
    // }
}
