<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ModelLogging;

class Profile extends Model
{
    use HasFactory;
    use ModelLogging;

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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
