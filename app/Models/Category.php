<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status'];

    const STATUS_ACTIVE     = 'active';
    const STATUS_INACTIVE   = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE     => 'Active',
        self::STATUS_INACTIVE   => 'In Active',
    ];

    public function tasks(){
        return $this->hasMany(Task::class, 'category_ids');
    }

    public function users(){
        return $this->hasMany(User::class, 'category_ids');
    }
}
