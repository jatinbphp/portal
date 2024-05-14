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
   
    protected $fillable = ['added_by', 'name', 'email', 'password', 'role', 'image', 'phone', 'status', 'practice_ids','company_ids','branch_ids'];

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
    const COMPANIES = "companies";
    const CONTROLLERS = "controllers";
    const ACCOUNTANTS = "accountants";
    const SERVICE_PROVIDERS = "service_providers";

    public static $roles = [
        self::ACCOUNTANTS => "Accountant Users",
        self::COMPANIES => "Company Users",
        self::CONTROLLERS => "Controller Users",
        self::SERVICE_PROVIDERS => "Service Provider Users",
        self::SUPER_ADMIN => "Super Admin",
    ];

    public function getFullNameAttribute(){
        return $this->name.' ('.$this->email.')';
    }

    public function company(){
        return $this->belongsTo(Account::class, 'company_ids');
    }

    public function service_provider(){
        return $this->belongsTo(Account::class, 'company_ids');
    }
}
