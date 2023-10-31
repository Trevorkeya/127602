<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'type' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
