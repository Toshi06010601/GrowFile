<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelLogging;

class Article extends Model
{
    use ModelLogging;
    
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
