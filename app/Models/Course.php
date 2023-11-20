<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['course_code', 'description', 'title', 'enrollment_key', 'background_image', 'user_id'];

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
