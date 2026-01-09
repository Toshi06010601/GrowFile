<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function studyRecords()
    {
        return $this->hasMany(StudyRecord::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function authFollows()
    {
        // Check if the currently authenticated user follows this user
        return $this->hasOne(Follow::class, 'followed_id', 'id')
                    ->where('follower_id', Auth::id());
    }

    public function authFollowed()
    {
        // Check if this user follows the currently authenticated user 
        return $this->hasOne(Follow::class, 'follower_id', 'id')
                    ->where('followed_id', Auth::id());
    }
    
    public function profiles()
    {
        return $this->hasOne(Profile::class);
    }

    public function userSkills ()
    {
        return $this->hasMany(UserSkill::class, 'user_id');
    }

    public function readingLogs ()
    {
        return $this->hasMany(ReadingLog::class, 'user_id');
    }

    public function portfolios ()
    {
        return $this->hasMany(Portfolio::class, 'user_id');
    }
}
