<?php

namespace App\Http\Middleware;

use App\Models\Evaluation;
use App\Models\Event;
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

        $user = Auth::user();

        $evaluation_form = $event->evaluations()->where('user_id', $user->id)->first();

        if($evaluation_form !== null){
            return response([
                'message' => "you already Response in Evaluation"
            ], 400);
        }


        return $next($request);
    }
}
