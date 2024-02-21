<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
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
        $user = User::whereId($id)->with(['profile'])->first();



        return response([
            'user' => $user
        ], 200);
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

        $user = User::find($id);

        $profile = $user->profile;



        if ($request->password !== null) {
            $validator = Validator::make($request->all(), [
                // 'name' => 'required',
                // 'email' => 'required|unique:users,email',
                'password' => 'required|confirmed|min:8',
                // 'last_name' => 'required',
                // 'first_name' => 'required',
                // 'student_id' => 'required',
                // 'age' => 'required',
                // 'gender' => 'required',
                // 'section' => 'required',
                // 'course' => 'required',
                // 'image' => 'required|sometimes|base64mimes:jpeg, png, jpg',
                // 'valid_documents' => 'required|sometimes|base64mimes:jpeg, jpg',
                // 'address' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if ($request->email !== null) {
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            $user->update([
                'email' => $request->email
            ]);
        }


        if ($request->image !== null) {

            $validator = Validator::make($request->all(), [
                'image' => 'sometimes|base64mimes:jpeg, png, jpg',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            $image = $request->image;
            $imageName = $this->base64ImageHandler($image, 'profile/', 'IMG');

            $user->profile->update([
                'image' => asset('/storage/profile/' . $imageName),
            ]);
        }

        if ($request->valid_documents !== null) {
            $validator = Validator::make($request->all(), [
                'valid_documents' => 'sometimes|base64mimes:jpeg, jpg',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            $documentImage = $request->valid_documents;


            $documentImageName = $this->base64ImageHandler($documentImage, 'document/', 'DCMNTS');



            $user->profile->update([
                'valid_documents' => asset('/storage/document/' . $documentImageName),
            ]);
        }


        $user->update([
            'name' => $request->name ?? $user->name
        ]);

        $user->profile->update([
            'last_name' => $request->last_name ?? $profile->last_name,
            'first_name' => $request->first_name ?? $profile->first_name,
            'middle_name' => $request->middle_name ?? $profile->middle_name,
            'student_id' => $request->student_id ?? $profile->student_id,
            'age' => $request->age ?? $profile->age,
            'gender' => $request->gender ?? $profile->gender,
            'section' => $request->section ?? $profile->section,
            'course' => $request->course ?? $profile->course,
            'address' => $request->address ?? $profile->address,
        ]);

        return response([
            'message' => 'profile Updated!',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
