<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\InstructorSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $instructor_info = $user->instructorInfo;


        $sections = InstructorSection::where('instructor_info_id', $instructor_info->id)->get();


        return view('users.instructor.section.index', compact(['sections']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $courses = Course::get();

        return view('users.instructor.section.create',  compact(['courses']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $user = Auth::user();

        $instractorInfo = $user->instructorInfo;

        collect($request->sections)->map(function($_section) use($instractorInfo){

            $section = Section::find($_section);

            InstructorSection::create([
                'section_id' => $section->id,
                'instructor_info_id' => $instractorInfo->id
            ]);

        });


        return back()->with(['message' => 'Section Added Success']);
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
        $section = InstructorSection::find($id);


        $section->delete();


        return back()->with(['message' => 'Section Deleted!']);
    }
}
