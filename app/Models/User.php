<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'two_factor_code'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function administrators()
    {
        return $this->hasOne(Administrators::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
    protected function type(): Attribute
   {
    $value = $this->attributes['type'];
    $transformed = ["user", "admin", "instructor", "manager"][$value];

    \Log::info("Type accessor: Input: $value, Output: $transformed");

    return new Attribute(
        get: fn ($value) => $transformed,
    );
   }

   

    
    public function twoFactorChallengePassed($code)
    {
        return $this->two_factor_code === $code;
    }
}
