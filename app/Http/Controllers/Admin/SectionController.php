<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;

class SectionController extends Controller
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
    public function create(string $id)
    {

        $course = Course::find($id);

        return view('users.admin.course.section.create', compact(['course']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year_level' => 'required',
            'section_number' => 'required'
        ]);

        $course = Course::find($request->course);


        Section::create([
            'number' => $request->section_number,
            'year' => $request->year_level,
            'course_id' => $course->id
        ]);


        return back()->with(['message' => 'Section Added']);
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
        $section = Section::find($id);

        $section->delete();

        return back()->with(['message' => 'Section Deleted']);
     }
}
