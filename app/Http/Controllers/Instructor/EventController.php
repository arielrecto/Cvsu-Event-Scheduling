<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {

        $currentDate = Carbon::now('Asia/Manila')->format('Y-m-d');

        $passed_events = Event::where('end_date', '<', $currentDate)->latest()->paginate(10);

        $event = Event::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();

        $incoming_events = Event::where('start_date', '>', $currentDate)->latest()->paginate(10);

        return view('users.instructor.event.index', compact(['passed_events', 'event', 'incoming_events']));
    }
    public function show(string $id)
    {

        $event = Event::find($id);

        return view('users.instructor.event.show', compact(['event']));
    }
    public function current(string $id)
    {
        $event = Event::find($id);

        return view('users.instructor.event.current',  compact(['event']));
    }

    public function eventAttendances($id)
    {

        $event = Event::find($id);

        $attendances = $event->attendances()->with(['user.profile' => function ($q) {
            $q->with(['course', 'section']);
        }])->latest()->get();


        return response([
            'attendances' => $attendances
        ], 200);
    }
}
