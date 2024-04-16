<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSpeaker extends Model
{
    use HasFactory;


    protected $fillable = [
        'image',
        'last_name',
        'first_name',
        'middle_name',
        'age',
        'gender',
        'address',
        'occupation',
        'valid_documents',
        'description'
    ];


    public function events(){
        return $this->hasMany(EventHost::class, 'event_speaker_id');
    }

    public function fullName():string{
        $full_name = $this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name;

        return $full_name;
    }
    public function dateCreated():string{
        $date = date('F d, Y', strtotime($this->created_at));


        return $date;
    }
}
