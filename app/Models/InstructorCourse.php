<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_info_id',
        'course_id'
    ];


    public function instructor (){
        return $this->belongsTo(InstructorInfo::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

}
