<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'employee_id',
        'email',
        'password',
        'phone',
        'designation',
        'unit_id',
        'department',
        'reporting_persons'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createUser($name,$employee_id, $email, $password, $designation,$phone,$unit_id, $department, $reporting_persons)
    {
        return self::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'designation' => $designation,
            'employee_id' => $employee_id,
            'password' => bcrypt($password),
            'unit_id' => $unit_id,
            'department' => $department,
            'reporting_persons' => $reporting_persons
        ]);
    }

    public static function findUserByEmail($email)
    {
        return self::where('email', $email)->first();
    }  
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


}
