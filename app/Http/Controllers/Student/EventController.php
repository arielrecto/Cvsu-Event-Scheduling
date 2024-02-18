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
        //
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
        //
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
        $event_time_end = Carbon::parse($event->end_time);

        $current_date = Carbon::now('GMT+8')->format('F d, Y');



        if($user->attendances()
        ->whereDate('created_at',now()->toDateString())
        ->where('event_id', $event->id)
        ->whereNotNull('time_out')->whereNotNull('time_in')->latest()->first() !== null){

            return response([
                'message' => "You Have Attendance Today {$current_date}"
            ], 200);
        }

        $attendance = $user->attendances()
        ->whereDate('created_at',now()->toDateString())
        ->where('event_id', $event->id)
        ->whereNull('time_out')->latest()->first();


        if ($attendance !== null && $event_time_end->lt($current_time)) {

            $attendance->update([
                'time_out' =>  Carbon::now('GMT+8')->format('h:i A')
            ]);

            return response([
                'message' => "Time Out @ {$current_time}"
            ], 200);
        };



        Attendance::create([
            'time_in' => $current_time,
            'event_id' => $event->id,
            'user_id' => $user->id
        ]);


        return response([
            'message' => "Time in @ {$current_time}"
        ], 200);
    }
    public function evaluation(Request $request, string $event_ref){
        $event = Event::where('ref', $event_ref)->first();

        $user = Auth::user();

        Evaluation::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'result' => $request->result,
            'form' => $request->form,
            'average' => $request->average
        ]);

        return response([
            'message' => 'Evaluation Submitted',
        ], 200);
    }
}
