<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DailyPerformance extends Model
{
    use HasFactory,SoftDeletes ;

    protected $fillable = ['user_id', 'task_id', 'category_id','datetime', 'comment'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

}
