<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;
    protected $table = 'campuses';

    protected $fillable = [
        'name', 
        'campus_code', 
        'location',
        'district',
    ];
}
