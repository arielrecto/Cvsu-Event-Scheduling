<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];


    public function sections(){
        return $this->hasMany(InstructorSection::class);
    }

    public function courses(){
        return $this->hasMany(InstructorCourse::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
