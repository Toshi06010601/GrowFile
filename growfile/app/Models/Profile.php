<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'full_name',
        'profile_image',
        'headline',
        'bio',
        'job_status',
        'visibility',
        'location',
        'github_link',
        'linkedin_link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
