<?php

use App\Models\User;
use App\Models\Event;
use App\Enums\UserRolesEnum;
use App\Models\EvaluationForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\EventSpeakerController;
use App\Http\Controllers\Admin\EvaluationFormController;
use App\Http\Controllers\Student\EventController as StudentEventController;
use App\Http\Controllers\Student\StudentController as StudentStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {

    $events = Event::with(['speaker'])->latest()->paginate(10);

    $totalUnverifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
        $q->whereNull('verified_at');
    })->count();

    $totalVerifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
        $q->whereNotNull('verified_at');
    })->count();

    $events_json = Event::get()->toJson();

    return view('dashboard', compact(['events', 'events_json', 'totalUnverifiedStudent', 'totalVerifiedStudent']));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', function () {
    return to_route('home');
});

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('event')->as('event.')->group(function(){
        Route::get('/portal/{event_ref}', function($event_ref){
            $event = Event::where('ref', $event_ref)->first();

            $user = Auth::user();


            $attendance = $event->attendances()->where('user_id', $user->id)->whereDate('created_at', now())->first();

            return view('users.students.attendance.index', compact(['event', 'attendance']));
        })->name('portal');

        Route::post('/portal/{event_ref}/attendance', [StudentEventController::class, 'attendance'])->name('attendance')->middleware(['event-attendance']);
    });


    Route::middleware(['role:admin'])->group(function () {


        Route::prefix('students')->as('students.')->group(function () {
            Route::get('approved/{student}', [StudentController::class, 'approved'])->name('approved');
        });

        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/{event}/evaluation/form', [EvaluationFormController::class, 'create'])->name('evaluation.form.create');
            Route::post('evaluation/store', [EvaluationFormController::class, 'store'])->name('evaluation.form.store');
            Route::get('{event}/report', [EventController::class, 'report'])->name('report');
        });



        Route::resource('announcements', AnnouncementController::class);
        Route::resource('events', EventController::class);
        Route::resource('event/speaker', EventSpeakerController::class);
        Route::resource('students', StudentController::class);
    });
});

require __DIR__ . '/auth.php';
