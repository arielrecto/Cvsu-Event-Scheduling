<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use App\Enums\UserRolesEnum;
use Illuminate\Http\Request;
use App\Models\InstructorInfo;
use App\Models\InstructorCourse;
use App\Http\Controllers\Controller;
use App\Models\InstructorSection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $instructors = User::whereHas('roles', function($q){
            $q->where('name', UserRolesEnum::INSTRUCTOR->value);
        })->paginate(10);

        return view('users.admin.instructor.index', compact(['instructors']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $courses = Course::get();

        return view('users.admin.instructor.create', compact(['courses']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed',
            'name' => 'required',
            'course' => 'required',
            'sections' => 'required'
        ]);



        $course = Course::where('name', $request->course)->first();


        $instructor = Role::where(['name' => UserRolesEnum::INSTRUCTOR->value])->first();


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



        $user->assignRole($instructor);



        $instractorInfo = InstructorInfo::create([
            'user_id' => $user->id
        ]);

        InstructorCourse::create([
            'instructor_info_id' => $instractorInfo->id,
            'course_id' => $course->id
        ]);


        collect($request->sections)->map(function($_section) use($instractorInfo){

            $section = Section::find($_section);

            InstructorSection::create([
                'section_id' => $section->id,
                'instructor_info_id' => $instractorInfo->id
            ]);

        });


        return back()->with(['message' => 'Instructor Added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instructor = User::find($id);



        return view('users.admin.instructor.show', compact(['instructor']));
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
        $instructor = User::find($id);

        $instructor->delete();


        return to_route('instructors.index');
    }
}
