<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'site_url',
        'github_url',
        'site_image_path',
        'description',
        'comment',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
