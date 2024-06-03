<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function verify(string $id){


        $user = User::find($id);


        $user->markEmailAsVerified();

        return to_route('login')->with(['message' => 'email verified']);
    }
}
