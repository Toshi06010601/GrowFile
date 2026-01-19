<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelLogging;

class Experience extends Model
{
    use ModelLogging;
    
    protected $fillable = [
        'user_id',
        'company_name',
        'start_month',
        'end_month',
        'role',
        'description'
    ];

    protected $casts = [
        'start_month' => 'date',
        'end_month' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
