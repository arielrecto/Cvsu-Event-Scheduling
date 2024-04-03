<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_info_id',
        'section_id'
    ];



    public function instructor(){
        return $this->belongsTo(InstructorInfo::class);
    }

    public function section (){
        return $this->belongsTo(Section::class);
    }
}
