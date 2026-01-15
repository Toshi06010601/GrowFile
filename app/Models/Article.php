<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'platform_name',
        'published_date',
        'article_url',
        'article_image_path',
    ];

    protected $casts = [
        'published_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
