<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'image',
        'ref',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'description',
        'location',
        'status',
        'is_done',
        'is_archive',
        'category'
    ];


    public function hosts(){
        return $this->hasMany(EventHost::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function evaluationForm()
    {
        return $this->hasOne(EvaluationForm::class);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    public function dateDuration(): string
    {
        $start_date = date('F d, Y', strtotime($this->start_date));
        $end_date = date('F d, Y', strtotime($this->end_date));
        return "{$start_date} - {$end_date}";
    }
    public function timeDuration(): string
    {

        $start_time = date('h:i A', strtotime($this->start_time));

        $end_time = date('h:i A', strtotime($this->end_time));

        return "{$start_time} - {$end_time}";
    }
    public function address(): string
    {


        $location = json_decode($this->location);


        return "{$location->address}";
    }
    public function evaluationsAverage(): float
    {
        $average = $this->evaluations()->avg('average');


        return $average ?? 0.0;
    }
    public function evaluationsResult ()
    {
        $mostUsed = $this->evaluations()->select('result', DB::raw('COUNT(*) as word_count'))
            ->groupBy('result')
            ->orderByDesc('word_count')
            ->first();

        if ($mostUsed !== null) {
            $word = $mostUsed->result;
            $wordCount = $mostUsed->word_count;
            // Your logic with the most frequent word and its count
        } else {
          $word = "No Result";
        }

       return $word;
    }
}
