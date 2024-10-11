<?php

namespace App\Models;

use Illuminate\Console\View\Components\Secret;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    
    protected $table = 'campuses'; // The table name

    protected $fillable = [
        'name',              // Name of the campus
        'campus_code',       // Short code for the campus
        'location',          // Full address of the campus
        'district',          // District/City
        'state',             // State or province
        'phone_number',      // Campus contact number
        'email',             // Campus email
        'principal',         // Campus principal's name
        'is_active',         // Whether the campus is active
        'parent_school_id',  // Foreign key to the parent school (if any)
        'campus_type',       // Type of campus (e.g., Primary, Secondary)
    ];

    public function school(){
        return $this->belongsTo(School::class, 'parent_school_id');
    }
    public function schoolClasses(){
        return $this->hasMany(SchoolClass::class);
    }
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function section(){
        return $this->hasMany(Section::class);
    }
}
