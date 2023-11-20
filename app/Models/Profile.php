<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number', 'image', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'user_id', 'user_id');
    }

    public function administrators()
    {
        return $this->hasOne(Administrators::class, 'user_id', 'user_id');
    }
    
}
