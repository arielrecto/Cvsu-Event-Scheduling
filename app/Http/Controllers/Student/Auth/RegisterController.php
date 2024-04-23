<?php

namespace App\Http\Controllers\Student\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Enums\UserRolesEnum;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {




        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'last_name' => 'required',
            'first_name' => 'required',
            'student_id' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'section' => 'required',
            'course' => 'required',
            // 'image' => 'required|sometimes|base64mimes:jpeg, png, jpg',
            'valid_documents' => 'required|sometimes|base64mimes:jpeg, jpg',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $studentRole = Role::where('name', UserRolesEnum::STUDENT->value)->first();



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        // $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
        // $dir = $request->image->storeAs('/profile', $imageName, 'public');


        // $image = $request->image;  // your base64 encoded
        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName =  'IMG-' . uniqid() . '.' . 'png';
        // $filename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $imageName);

        // $imageDecoded = base64_decode($image);

        // Storage::disk('public')->put('profile/' . $filename, $imageDecoded);

        // $imageName = $this->base64ImageHandler($image, 'profile/', 'IMG');

        // $documentImage = 'DCMNTS-' . uniqid() . '.' . $request->valid_documents->extension();
        // $valid_dir = $request->valid_documents->storeAs('/document', $documentImage, 'public');


        $documentImage = $request->valid_documents;  // your base64 encoded
        $documentImage = str_replace('data:image/png;base64,', '', $documentImage);
        $documentImage = str_replace(' ', '+', $documentImage);
        $documentImageName =  'DCMNTS-' . uniqid() . '.' . 'png';
        $documentFilename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $documentImageName);

        $documentImageDecoded = base64_decode($documentImage);

        Storage::disk('public')->put('document/' . $documentFilename, $documentImageDecoded);

        $documentImageName = $this->base64ImageHandler($documentImage, 'document/', 'DCMNTS');


        $course = Course::where('name', $request->course)->first();
        $section = Section::find($request->section);


        $profile = Profile::create([
            // 'image' => asset('/storage/profile/' . $imageName),
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'student_id' => $request->student_id,
            'age' => $request->age,
            'gender' => $request->gender,
            'section_id' => $section->id,
            'course_id' => $course->id,
            'address' => $request->address,
            'valid_documents' => asset('/storage/document/' . $documentImageName),
            'user_id' => $user->id
        ]);



        $user->assignRole($studentRole);




        return response(['message' => 'Register Success Admin will review your application'], 200);
    }


    private function base64ImageHandler($base64, string $path, string $name)
    {
        $image = $base64;  // your base64 encoded

          $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName =  "{$name}-" . uniqid() . '.' . 'png';
        $filename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $imageName);

        $imageDecoded = base64_decode($image);

        Storage::disk('public')->put($path . $filename, $imageDecoded);

        return $filename;
    }
}
