<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventSpeaker;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EventHost;
use App\Models\SchoolYear;

use function PHPSTORM_META\map;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;

        $events = Event::with(['hosts.speaker'])->where('is_archive', false)->latest()->paginate(10);


        if ($search) {

            $events = Event::where('name', 'like', '%' . $search . '%')
                ->where('is_archive', false)
                ->orWhereYear('start_date', $search)
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

        $schoolYears = SchoolYear::get();

        return view('users.admin.events.create', compact(['speakers', 'schoolYears']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'category' => 'required'
        ]);


        if (Carbon::parse($request->start_date)->isPast() || Carbon::parse($request->end_date)->isPast()) {
            return back()->with(['error' => 'Event Date Duration is in past']);
        }



        $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/event', $imageName, 'public');



        $event_ref = 'VNT-' . uniqid() . now()->format('Y-m-d');


        $event = Event::create([
            'image' => asset('/storage/' . $dir),
            'ref' => $event_ref,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'location' => $request->locations,
            'category' => $request->category
        ]);

        $speakers = $request->speakers;



        if ($speakers !== null) {
            collect($speakers)->map(function ($speaker) use ($event) {
                EventHost::create([
                    'event_id' => $event->id,
                    'event_speaker_id' => $speaker
                ]);
            });
        }



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

        if ($locations->address !== null) {
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
            'description' => $request->description === "<p><br></p>" ? $event->description : $request->description
        ]);


        $speakers = $request->speakers;

        if ($speakers !== null) {

            $hosts = $event->hosts;

            if (count($hosts) !== 0) {
                collect($hosts)->map(function ($host) {
                    $_host = EventHost::find($host->id);

                    $_host->delete();
                });
            }


            collect($speakers)->map(function ($speaker) use ($event) {
                EventHost::create([
                    'event_id' => $event->id,
                    'event_speaker_id' => $speaker
                ]);
            });
        }


        return back()->with(['message' => 'Event Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);


         $event->delete();

        // $event->update([
        //     'is_archive' => true
        // ]);

        return back()->with(['message' => 'Event Deleted']);
    }
    public function report(string $id)
    {

        $event = Event::find($id);

        $attendancesByCourse = $event->attendances()
            ->with('user.profile') // Ensure the necessary relationships are loaded
            ->get()
            ->groupBy(function ($attendance) {
                return $attendance->user->profile->course->name;
            })
            ->map(function ($attendances) {
                return $attendances->count();
            })
            ->toArray();



        $attendancesByCourse_json = json_encode([$attendancesByCourse]);

        return view('users.admin.events.report.show', compact(['event', 'attendancesByCourse_json', 'attendancesByCourse']));
    }
    public function searchAttendance(string $id, Request $request)
    {

        $attendances = Attendance::where('event_id', $id)
            ->with(['user.profile' => function ($q) {
                $q->with(['course', 'section']);
            }, 'event'])->latest()->get();

        $search = $request->search;

        if ($search !== null) {
            $attendances = Attendance::where(function ($q) use ($search, $id) {
                $q->where('event_id', $id)->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('profile', function ($q) use ($search) {
                            $q->where('last_name', 'like', '%' . $search . '%')
                                ->orWhere('first_name', 'like', '%' . $search . '%')
                                ->orWhere('gender', 'like', '%' . $search . '%')
                                ->orWhereHas('course', function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . $search . '%');
                                })
                                ->orWhereHas('section', function ($q) use ($search) {
                                    $q->where('year', 'like', '%' . $search . '%')
                                        ->orWhere('number', 'like', '%' . $search . '%');
                                });
                        });
                });
            })->with(['user.profile' => function ($q) {
                $q->with(['course', 'section']);
            }, 'event'])->get();
        }

        return $attendances;
    }
    public function archives(Request $request)
    {

        $search = $request->search;

        $events = Event::with(['hosts.speaker'])->where('is_archive', true)->latest()->paginate(10);


        if ($search) {

            $events = Event::where('name', 'like', '%' . $search . '%')
                ->where('is_archive', true)
                ->orWhereYear('start_date', $search)
                ->orWhereYear('end_date', $search)
                ->paginate(10);
        }





        return view('users.admin.events.archive', compact(['events']));
    }
    public function archiveStore(Request $request, string $id)
    {

        $event = Event::find($id);

        $event->update([
            'is_archive' => true
        ]);

        return back()->with(['message' => 'Event Archive Success']);
    }

    public function archiveRestore(string $id){
        $event = Event::find($id);

        $event->update([
            'is_archive' => false
        ]);

        return back()->with(['message' => 'Event Archive Restore']);
    }
    public function printShow(string $id){

        $event = Event::whereId($id)->first();
        $form =  json_decode($event->evaluationForm->form);


        return view('users.admin.events.evaluation-form.print', compact(['form', 'event']));
    }
}
