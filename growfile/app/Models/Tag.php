<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function studyRecords (): BelongsToMany
    {
        return $this->belongsToMany(studyRecord::class, 'study_records_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
