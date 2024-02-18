<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventSpeaker;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;

        $events = Event::with(['speaker'])->latest()->paginate(10);


        if($search){

            $events = Event::where('name', 'like', '%' . $search . '%')
            ->orWhereYear('start_date',$search)
            ->orWhereYear('end_date', $search)
            ->paginate(10);
        }





        return view('users.admin.events.index', compact(['events']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $speakers = EventSpeaker::latest()->get();

        return view('users.admin.events.create', compact(['speakers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'speaker' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);



        $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/event/', $imageName, 'public');



        $event_ref = 'VNT-' . uniqid() . now()->format('Y-m-d');


        Event::create([
            'image' => asset('/storage/' . $dir),
            'ref' => $event_ref,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'location' => $request->locations,
            'event_speaker_id' => $request->speaker
        ]);




        return to_route('events.index')->with([
            'message' => 'Event Added Success'
        ]);
        // EventSpeaker::create([
        //     'image'
        // ])
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);


        $attendancesByCourse = $event->attendances()
            ->with('user.profile') // Ensure the necessary relationships are loaded
            ->get()
            ->groupBy(function ($attendance) {
                return $attendance->user->profile->course;
            })
            ->map(function ($attendances) {
                return $attendances->count();
            })
            ->toArray();



        $attendancesByCourse_json = json_encode([$attendancesByCourse]);


        return view('users.admin.events.show', compact(['event', 'attendancesByCourse_json']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $event = Event::find($id);


        $speakers = EventSpeaker::latest()->get();

        return view('users.admin.events.edit', compact(['event', 'speakers']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);




        if ($request->has('image')) {

            $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/event/', $imageName, 'public');

            $event->update([
                'image' => asset('/storage/' . $dir)
            ]);
        }


        $locations = json_decode($request->locations);

        if($locations->address !== null){
            $event->update([
                'location' => $request->locations
            ]);
        }


        $event->update([
            'name' => $request->name ?? $event->name,
            'start_date' => $request->start_date ?? $event->start_date,
            'end_date' => $request->end_date ?? $event->end_date,
            'start_time' => $request->start_time ?? $event->start_time,
            'end_time' => $request->end_time ?? $event->end_time,
        ]);


        return back()->with(['message' => 'Event Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);


        $event->delete();


        return back()->with(['message' => 'Event Deleted']);
    }
    public function report(string $id)
    {

        $event = Event::find($id);

        $attendancesByCourse = $event->attendances()
            ->with('user.profile') // Ensure the necessary relationships are loaded
            ->get()
            ->groupBy(function ($attendance) {
                return $attendance->user->profile->course;
            })
            ->map(function ($attendances) {
                return $attendances->count();
            })
            ->toArray();



        $attendancesByCourse_json = json_encode([$attendancesByCourse]);

        return view('users.admin.events.report.show', compact(['event', 'attendancesByCourse_json', 'attendancesByCourse']));
    }
}
