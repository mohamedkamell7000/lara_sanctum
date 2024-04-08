<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable=[
        'owner_id',
        'address',
        'type',
        'size',
        'bedrooms',
        'bathrooms',
        'description',
        'location',
        'city',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
