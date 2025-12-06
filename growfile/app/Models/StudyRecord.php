<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudyRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'category',
        'activity',
        'start_datetime',
        'end_datetime'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime'
    ];

    public function tags (): BelongsToMany 
    {
        return $this->belongsToMany(Tag::class, 'study_records_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
