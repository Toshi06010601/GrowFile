<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyRecord extends Model
{
       protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_datetime',
        'end_datetime'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime'
    ];
}
