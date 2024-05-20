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

    public function tasks(){
        return $this->hasMany(Task::class, 'id', 'task_id'); 
    }

    public function getDatetimeAttribute($date){
        return \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $date)->format('Y-m-d H:i:s');
    }
}
