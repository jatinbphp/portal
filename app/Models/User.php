<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $appends = ['full_name'];
   
    protected $fillable = ['category_ids', 'branch_name', 'name', 'email', 'password', 'role', 'status'];

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
        'password' => 'hashed',
    ];

    /* user roles */
    const SUPER_ADMIN = "super_admin";
    const EMPLOYEES = "employees";

    public static $roles = [
        self::EMPLOYEES => "Employees",
        self::SUPER_ADMIN => "Super Admin",
    ];

    public function getFullNameAttribute(){
        return $this->name.' ('.$this->email.')';
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    // public function tasks(){
    //     return $this->hasManyThrough(Task::class, Category::class);
    // }

}
