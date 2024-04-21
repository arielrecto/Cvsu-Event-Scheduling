<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

        $user = Auth::user();

        $current_date = now();

        $current_time = Carbon::now('GMT+8');

        $start_date = Carbon::parse($event->start_date);

        $end_date = Carbon::create($event->end_date);



        $start_time = Carbon::parse($event->start_time)->format('h:s A');

        $end_time = Carbon::parse($event->end_time)->format('h:s A');

        if ($start_date->gt($current_date)) {
            // return back()->with([
            //     'message' => "The Event will Start at {$start_date->format('F d, Y')}, The system process Attendance"
            // ]);

            return response([
                'message' => "The Event will Start at {$start_date->format('F d, Y')}, The system process Attendance"
            ],200);
        };

        if ($end_date->addDay(1)->lt($current_date)) {
            // return back()->with([
            //     'message' => "The Event is Ended at {$end_date->format('F d, Y')}, The system process Attendance"
            // ]);
            return response([
                'message' => "The Event is Ended at {$end_date->format('F d, Y')}, The system process Attendance"
            ],200);
        }

        if ($current_time->lt($event->start_time)) {
            // return back()->with([
            //     'message' => "The Event starts at {$start_time}, You can only time in when the event starts"
            // ]);

            return response([
                 'message' => "The Event starts at {$start_time}, You can only time in when the event starts"
            ],200);
        }

        if (
            $current_time->gt($end_date->addDay(1)) && $user->attendances()->whereDate('created_at', now()->toDateString())
            ->where('event_id', $event->id)->latest()->first() !== null
        ) {

            // return back()->with([
            //     'message' => "The Event Ends at {$end_time}, You can only time in when the event is start at tomorrow {$start_time}"
            // ]);
            return response([
                'message' => "The Event Ends at {$end_time}, You can only time in when the event is start at tomorrow {$start_time}"
           ],200);
        }


        return $next($request);
    }
}
