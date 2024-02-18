<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class EventAttendance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $event = Event::where('ref', $request->event_ref)->first();


        $current_date = now();

        $current_time = Carbon::now('GMT+8');

        $start_date = Carbon::parse($event->start_date);

        $end_date = Carbon::parse($event->end_date);

        $start_time = Carbon::parse($event->start_time)->format('h:s A');

        if($start_date->gt($current_date)){
            return response([
                'message' => "The Event will Start at {$start_date->format('F d, Y')}, The system process Attendance"
            ], 400);
        };

        if($end_date->lt($current_date)){
            return response([
                'message' => "The Event is Ended at {$start_date->format('F d, Y')}, The system process Attendance"
            ], 400);
        }

        if($current_time->lt($event->start_time)){
            return response([
                'message' => "The Event is start at {$start_time}, The system process Attendance"
            ], 400);
        }


        return $next($request);
    }
}
