<?php

namespace App\Http\Controllers\student;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->with([
                'user.profile' => function ($q) {
                    $q->with(['course', 'section']);
                }
            , 'event'])->latest()->get();



        return response([
            'attendances' => $attendances
        ], 200);
    }
}
