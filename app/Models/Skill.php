<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelLogging;

class Skill extends Model
{
    use ModelLogging;
    
    protected $fillable = [
        'name',
        'category'
    ];

    public function userSkills ()
    {
        return $this->hasMany(UserSkill::class, 'skill_id');
    }

}
