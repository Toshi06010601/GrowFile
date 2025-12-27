<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingLog extends Model
{
    
    protected $fillable = [
        'user_id',
        'title',
        'cover_url',
        'author',
        'status',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
