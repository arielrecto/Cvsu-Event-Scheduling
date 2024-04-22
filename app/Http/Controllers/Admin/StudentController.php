<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\StudentRegistrationNotification;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // dd($request->filter);

        $filter = $request->filter;

        $search = $request->search;


        $students = User::role('student')->whereHas('profile', function ($q) {
            $q->whereNotNull('verified_at');
        })->latest()->paginate(10);


        $totalUnverifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
            $q->whereNull('verified_at');
        })->count();

        $totalVerifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
            $q->whereNotNull('verified_at');
        })->count();

        if ($filter !== null) {
            $students = User::role('student')->whereHas('profile', function ($q) {
                $q->whereNull('verified_at');
            })->latest()->paginate(10);
        }

        if ($search !== null) {
            $students = User::where(function ($query) use ($search) {
                $query->whereHas('profile', function ($q) use ($search) {
                    $q->where('last_name', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('course', 'like', '%' . $search . '%')
                        ->orWhere('section', 'like', '%' . $search . '%')
                        ->orWhere('student_id', 'like', '%' . $search . '%');
                })
                ->orWhere('name', 'like', '%' . $search . '%');
            })
            ->paginate(10);
        }




        return view('users.admin.students.index', compact(['students', 'totalUnverifiedStudent', 'totalVerifiedStudent']));
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
        $student = User::find($id);

        return view('users.admin.students.show', compact(['student']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $student = User::find($id);

        return view('users.admin.students.edit', compact(['student']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::find($id);


        $profile = $user->profile;


        if ($request->password !== null) {
            $request->validate([
                'password' => 'confirmed'
            ]);
        }

        if ($request->has('image')) {

            $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/profile', $imageName, 'public');

            $profile->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }

        if ($request->has('valid_documents')) {
            $documentImage = 'DCMNTS-' . uniqid() . '.' . $request->valid_documents->extension();
            $valid_dir = $request->valid_documents->storeAs('/document', $documentImage, 'public');

            $profile->update([
                'valid_documents' => asset('/storage/' . $valid_dir),
            ]);
        }


        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
        ]);

        $profile->update([
            'last_name' => $request->last_name ?? $profile->last_name,
            'first_name' => $request->first_name ?? $profile->first_name,
            'middle_name' => $request->middle_name ?? $profile->middle_name,
            'age' => $request->age ?? $profile->age,
            'gender' => $request->gender ?? $profile->gender,
            'student_id' => $request->student_id ?? $profile->student_id,
            'course' => $request->course ?? $profile->course,
            'section' => $request->section ?? $profile->section,
            'address' => $request->address ?? $profile->address
        ]);



        return back()->with(['message' => 'Student Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();

        return back()->with(['message' => 'Student Data Deleted']);
    }
    public function approved(string $id)
    {

        $student = User::find($id);

        $student->profile()->update([
            'verified_at' => now()
        ]);


        $verified_date = date('F d, Y', strtotime($student->profile->verified_at));


        $details = [
            'greeting' => "Good Day Sir/Ma'am {$student->name}",
            'body' => "Your Account is Verified by Admin @{$verified_date}"
        ];


        $student->notify(new StudentRegistrationNotification($details));


        return back()->with(['message' => 'Account is Verified']);
    }
    public function reject(string $id)
    {

        $student = User::find($id);


        $verified_date = date('F d, Y', strtotime(now()));


        $details = [
            'greeting' => "Good Day Sir/Ma'am {$student->name}",
            'body' => "Your Account is Rejected by Admin @ {$verified_date}"
        ];


        $student->notify(new StudentRegistrationNotification($details));


        $student->delete();


        return to_route('students.index')->with(['message' => 'Account is rejected']);
    }
}
