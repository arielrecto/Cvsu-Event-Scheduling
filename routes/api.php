<?php

use App\Models\Event;
use App\Models\Course;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\EventController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\Auth\RegisterController;
use App\Http\Controllers\Student\Auth\AuthenticationSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::prefix('mobile')->group(function() {
    Route::post('/student', [RegisterController::class, 'store']);
    Route::post('login', [AuthenticationSessionController::class, 'store']);

    Route::get('/landing', function(Request $request){
        $announcements = Announcement::latest()->first();

        $events = Event::latest()->get();


        return response([
            'announcements' => $announcements,
            'events' => $events
        ], 200);
    });


    Route::get('/course', function(){
        $courses = Course::get();

        return response([
            'courses' => $courses
        ], 200);
    });


    Route::get('/course/{course}/sections', function(string $name){
        $course = Course::where('name', $name)->first();

        $sections = $course->sections;

        return response([
            'sections' => $sections
        ], 200);
    });




    Route::get('/public/event/{id}', function(string $id){
        $event = Event::whereId($id)->with(['speaker'])->first();


        return response([
            'event' => $event
        ], 200);
    });
});




Route::prefix('mobile')->as('mobile.')->middleware(['auth:sanctum', 'verified-student'])->group(function(){

    Route::get('/loadUser', function(){
        $user = Auth::user();

        return response([
            'user' => $user
        ], 200);
    });


    Route::get('', function(){
        $events = Event::with(['speaker', 'evaluationForm'])->latest()->get();

        $announcements = Announcement::latest()->paginate(5);

        return response([
            'events' => $events,
            'announcements' => $announcements
        ], 200);
    });

    Route::prefix('dashboard')->group(function(){
        Route::get('', [DashboardController::class, 'index']);
    });


    Route::prefix('event')->group(function (){
        // Route::post('/rf={event_ref}/attendance', [EventController::class, 'attendance'])->middleware(['event-attendance']);
        Route::post('/rf={event_ref}/evaluation', [EventController::class, 'evaluation'])->middleware(['event-evaluation']);
    });
    Route::resource('announcements', AnnouncementController::class)->only(['index', 'show']);
    Route::resource('event', EventController::class)->only(['index', 'show']);
    Route::resource('student', StudentController::class)->only(['update', 'show', 'destroy']);
    Route::post('logout', [AuthenticationSessionController::class, 'logout']);
});
