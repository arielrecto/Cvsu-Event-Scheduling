<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolYears = SchoolYear::latest()->paginate(10);


        return view('users.admin.school-year.index', compact('schoolYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.school-year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_year' => 'required',
            'end_year' => 'required'
        ]);


        SchoolYear::create([
            'year' => "{$request->start_year} - {$request->end_year}"
        ]);


        return back()->with(['message' => 'School Year Added']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schoolYear = SchoolYear::find($id);

        $events  =  Event::whereSchoolYear($schoolYear->year)->latest()->paginate(10);


        return view('users.admin.school-year.show', compact(['schoolYear', 'events']));
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
    public function printShow(string $id){

        $schoolYear = SchoolYear::find($id);

        $query =  Event::whereSchoolYear($schoolYear->year);

        $events = $query->get();

        $totalEvents = $query->count();
        $totalEventFirstSem = $query->where('semester', '1st Semester')->count();
        $totalEventSecondSem = $query->where('semester', '2nd Semester')->count();


        return view('users.admin.school-year.print', compact(['schoolYear', 'events','totalEvents', 'totalEventFirstSem', 'totalEventSecondSem']));
    }
}
