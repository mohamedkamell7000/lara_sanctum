<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable=[
        'img_name',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
