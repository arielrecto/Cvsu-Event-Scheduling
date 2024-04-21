<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();


        return response([
            'events' => $events
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::whereId($id)->with([
            'evaluationForm',
            'hosts.speaker',
        ])->first();


        $user = Auth::user();

        $event_evaluation_average = $event->evaluationsAverage();

        $event_evaluation_result = $event->evaluationsResult();

        $total_attendees = count($event->attendances()->get());


        $has_evaluation = User::find($user->id)->evaluations()->where('event_id', $event->id)->exists();


        $event_is_done = Carbon::parse($event->end_date)->lt(now());


        return response([
            'event' => $event,
            'event_evaluation_average' => $event_evaluation_average,
            'event_evaluation_result' => $event_evaluation_result,
            'total_attendees' => $total_attendees,
            'user_has_evaluation' => $has_evaluation,
            // 'attendance_link' => route('event.portal', ['event_ref' => $event->ref]),
            'event_is_done' => $event_is_done
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function attendance(string $event_ref)
    {
        $event = Event::where('ref', $event_ref)->first();

        $user = User::find(Auth::user()->id);


        $current_time =  Carbon::now('GMT+8')->format('h:i A');

        $event_time_start = Carbon::parse($event->start_time);
        $event_time_end = Carbon::create($event->end_time);

        $current_date = Carbon::now('GMT+8')->format('F d, Y');



        if ($user->attendances()
            ->whereDate('created_at', now()->toDateString())
            ->where('event_id', $event->id)
            ->whereNotNull('time_out')->whereNotNull('time_in')->latest()->first() !== null
        ) {

            // return back()->with([
            //     'message' => "You Have Attendance Today {$current_date}"
            // ]);
            return response([
                'message' => "You Have Attendance Today {$current_date}"
            ], 200);

        }

        $attendance = $user->attendances()
            ->whereDate('created_at', now()->toDateString())
            ->where('event_id', $event->id)
            ->whereNull('time_out')->latest()->first();


        if ($attendance !== null && $event_time_end->addDay(1)->gt($current_time)) {

            $attendance->update([
                'time_out' =>  Carbon::now('GMT+8')->format('h:i A')
            ]);

            // return back()->with([
            //     'message' => "Time Out @ {$current_time}"
            // ]);
            return response([
                'message' => "Time Out @ {$current_time}"
            ], 200);
        };


        Attendance::create([
            'time_in' => $current_time,
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);


        // return back()->with([
        //     'message' => "Time in @ {$current_time}"
        // ]);

        return response([
            'message' => "Time in @ {$current_time}"
        ], 200);
    }
    public function evaluation(Request $request, string $event_ref)
    {


        $event = Event::where('ref', $event_ref)->first();


        $form = json_encode($request->form);

        $user = Auth::user();

        Evaluation::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'result' => $request->result,
            'form' => $form,
            'average' => $request->average
        ]);

        return response([
            'message' => 'Evaluation Submitted',
        ], 200);
    }
}
