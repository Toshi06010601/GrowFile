<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'provider',
        'course_url',
        'progress_status',
        'certificate_url',
        'completion_date',
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
