<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelLogging;

class ReadingLog extends Model
{
    use ModelLogging;
    
    protected $fillable = [
        'user_id',
        'title',
        'cover_url',
        'author',
        'current_page',
        'total_pages',
        'review',
    ];

    protected $casts = [
        'current_page' => 'integer',
        'total_pages' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
