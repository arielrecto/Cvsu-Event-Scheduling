<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;



    protected $fillable = [
        'image',
        'student_id',
        'last_name',
        'first_name',
        'middle_name',
        'age',
        'gender',
        'address',
        'section_id',
        'course_id',
        'valid_documents',
        'verified_at',
        'user_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function fullName():string{
        $full_name = $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name;

        return $full_name;
    }
    public function dateCreated():string{
        $date = date('F d, Y', strtotime($this->created_at));


        return $date;
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
}
