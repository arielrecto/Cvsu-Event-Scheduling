<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationSessionController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }





        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response([
                'error' => [
                    'credentials' => 'Incorrect credentials please check email and password'
                ]
            ], 401);
        }


        $user = $request->user();


        if ($user->profile->verified_at === null) {
            return response([
                'error' => [
                    'credentials' => 'Your Account is not Verified by Admin please wait'
                ]
            ], 401);
        }


        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->plainTextToken;

        $user = Auth::user();

        return response([
            'message' => 'login Success',
            'token' => $token,
            'user' => $user,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response([
            'message' => 'logout success'
        ]);
    }
}
