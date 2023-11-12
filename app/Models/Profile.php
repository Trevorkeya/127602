<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['date_of_birth', 'phone_number'];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
