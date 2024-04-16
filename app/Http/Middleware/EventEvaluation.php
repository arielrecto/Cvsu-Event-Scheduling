<?php

namespace App\Http\Middleware;

use App\Models\Evaluation;
use App\Models\Event;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventEvaluation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $event = Event::where('ref', $request->event_ref)->first();

        $current_date = Carbon::now();

        $user = Auth::user();

        $evaluation_form = $event->evaluations()->where('user_id', $user->id)->first();

        $event_end_date = Carbon::parse($event->end_date);

        if($evaluation_form !== null){
            return response([
                'message' => "you already Response in Evaluation"
            ], 400);
        }

        if($event_end_date->lt($current_date)){
            return response([
                'message' => "Event is Ended at {$event_end_date}"
            ], 400);
        }


        return $next($request);
    }
}
