<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now('Asia/Manila')->format('Y-m-d');


        dd($currentDate);

        $event = Event::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)->first();



        dd($event);



        return view('users.instructor.dashboard', compact(['event']));
    }
}
