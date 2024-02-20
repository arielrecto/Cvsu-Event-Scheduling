<?php

namespace App\Http\Controllers\Student;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::whereMonth('start_date', now())->orWhere('end_date', now())->with(['speaker'])->get();
        $totalEvent = Event::count();
        $totalAnnouncement= Announcement::count();

        $latest_announcement = Announcement::latest()->first();
        $announcements = Announcement::latest()->get();


        return response([
            'events' => $events,
            'total_event' => $totalEvent,
            'total_announcement' => $totalAnnouncement,
            'latest_announcement' => $latest_announcement,
            'announcements' => $announcements
        ]);
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
}
