<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;


    protected $fillable = [
        'year',
        'number',
        'course_id'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function instructor(){
        return $this->hasMany(InstructorSection::class);
    }
    public function students(){
        return $this->hasMany(Profile::class);
    }
}
