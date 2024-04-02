<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::latest()->paginate(10);


        return view('users.admin.course.index', compact(['courses']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);


        Course::create([
            'name' => $request->name,
        ]);

        return back()->with(['message' => "Course Added"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);


        return view('users.admin.course.show', compact(['course']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $course = Course::find($id);

        return view('users.admin.course.edit', compact(['course']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $course = Course::find($id);


       $course->update([
        'name' => $request->name
       ]);



       return back()->with(['message' => 'Course Updated']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);


        $course->delete();


        return to_route('course.index')->with(['message' => 'Course Deleted']);
    }
}
