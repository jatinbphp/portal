<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'category_ids','status'];

    const STATUS_ACTIVE     = 'active';
    const STATUS_INACTIVE   = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE     => 'Active',
        self::STATUS_INACTIVE   => 'In Active',
    ];

    public function getCategoryNamesAttribute()
    {
        $categoryIds = explode(',', $this->category_ids);
        return Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }


}
