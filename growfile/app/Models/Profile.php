<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'full_name',
        'profile_image_path',
        'background_image_path',
        'headline',
        'bio',
        'job_status',
        'visibility',
        'location',
        'github_link',
        'linkedin_link'
    ];

    protected $casts = [
    'visibility' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
