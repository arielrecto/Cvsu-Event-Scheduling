<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form',
        'event_id'
    ];



    public function event(){
        return $this->belongsTo(Event::class);
    }
}
