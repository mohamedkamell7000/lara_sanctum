<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    use HasFactory;
    protected $table = 'fav_task_user';
    protected $fillable=[
        'user_id',
        'task_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    // public function img()
    // {
    //     return $this->hasManyThrough(Images::class,Task::class,'id','id','id','id');
    // }
    // public function owner()
    // {
    //     return $this->hasManyThrough(User::class,Task::class,'id','id','id','user_id');
    // }

    
}
