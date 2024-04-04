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
        $currentDate = Carbon::now('UTC+08');

        $event = Event::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate);

            dd($event->toSql());

            dd($event);



        return view('users.instructor.dashboard', compact(['event']));
    }
}
