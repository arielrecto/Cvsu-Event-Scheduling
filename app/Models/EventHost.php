<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventHost extends Model
{
    use HasFactory;


    protected $fillable = [
        'event_id',
        'event_speaker_id'
    ];



    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function speaker(){
        return $this->belongsTo(EventSpeaker::class, 'event_speaker_id');
    }
}
