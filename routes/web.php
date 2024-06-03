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
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Instructor\AttendanceController;
use App\Http\Controllers\Instructor\DashboardController;
use App\Http\Controllers\Instructor\EventController as InstructorEventController;
use App\Http\Controllers\Instructor\SectionController as InstructorSectionController;

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

    $user = Auth::user();

    if($user){
        Auth::logout();
    }

    return view('welcome');
})->name('home');


Route::get('home', [HomeController::class, 'index']);
Route::get('user-email-verify/{user}', [EmailVerificationController::class, 'verify'])->name('user.email.verify');

Route::get('/dashboard', function () {

    $events = Event::with(['hosts'])->where('is_archive', false)->latest()->paginate(10);

    $totalUnverifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
        $q->whereNull('verified_at');
    })->count();

    $totalVerifiedStudent = User::role(UserRolesEnum::STUDENT->value)->whereHas('profile', function ($q) {
        $q->whereNotNull('verified_at');
    })->count();

    $events_json = Event::where('is_archive', false)->get()->toJson();


    return view('dashboard', compact(['events', 'events_json', 'totalUnverifiedStudent', 'totalVerifiedStudent']));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', function () {
    return to_route('home');
});

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::prefix('event')->as('event.')->group(function(){
    //     Route::get('/portal/{event_ref}', function($event_ref){
    //         $event = Event::where('ref', $event_ref)->first();

    //         $user = Auth::user();

    //         $attendance = $event->attendances()->where('user_id', $user->id)->whereDate('created_at', now())->first();

    //         return view('users.students.attendance.index', compact(['event', 'attendance']));
    //     })->name('portal');

    //     Route::post('/portal/{event_ref}/attendance', [StudentEventController::class, 'attendance'])->name('attendance')->middleware(['event-attendance']);
    // });

    Route::prefix('section')->as('section.')->group(function(){
        Route::get('course/{course}', [SectionController::class, 'sectionCourse'])->name('course');
    });

    Route::middleware(['role:student'])->as('student.')->prefix('student')->group(function(){
        Route::get('', function (){
            return view('users.students.welcome');
        })->name('student.welcome');
    });


    Route::middleware(['role:admin'])->group(function () {


        Route::prefix('students')->as('students.')->group(function () {
            Route::get('approved/{student}', [StudentController::class, 'approved'])->name('approved');
            Route::get('reject/{student}', [StudentController::class, 'reject'])->name('reject');
        });

        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/{event}/evaluation/form', [EvaluationFormController::class, 'create'])->name('evaluation.form.create');
            Route::post('evaluation/store', [EvaluationFormController::class, 'store'])->name('evaluation.form.store');
            Route::get('{event}/report', [EventController::class, 'report'])->name('report');
            Route::get('{event}/attendances', [EventController::class, 'searchAttendance'])->name('attendances');
            Route::delete('evaluation/from/{form}/delete', [EvaluationFormController::class, 'destroy'])->name('evaluation.form.destroy');
            Route::get('/archives', [EventController::class, 'archives'])->name('archives');
            Route::post('/archives/{event}', [EventController::class, 'archiveStore'])->name('archives.store');
            Route::post('/archives/{event}/restore', [EventController::class, 'archiveRestore'])->name('archives.restore');
            Route::get('/{event}/form/print', [EventController::class, 'archiveRestore'])->name('form.print');
        });


        Route::prefix('course')->as('course.')->group(function(){
            Route::prefix('{course}/section')->as('section.')->group(function(){
                Route::get('create', [SectionController::class, 'create'])->name('create');
                Route::post('', [SectionController::class, 'store'])->name('store');
            });
        });

        Route::prefix('section')->as('section.')->group(function(){
            Route::delete('{section}/delete', [SectionController::class, 'destroy'])->name('destroy');
        });




        Route::resource('announcements', AnnouncementController::class);
        Route::resource('events', EventController::class);
        Route::resource('event/speaker', EventSpeakerController::class);
        Route::resource('students', StudentController::class);
        Route::resource('course', CourseController::class);
        Route::resource('instructors', InstructorController::class);
    });

    Route::middleware(['role:instructor'])->prefix('faculty')->as('faculty.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('events')->as('events.')->group(function(){
            Route::get('', [InstructorEventController::class, 'index'])->name('index');
            Route::get('{event}/show', [InstructorEventController::class, 'show'])->name('show');
            Route::get('{event}/current', [InstructorEventController::class, 'current'])->name('current');
            Route::get('{event}/report', [InstructorEventController::class, 'report'])->name('report');
            Route::get('{event}/attendances', [InstructorEventController::class, 'eventAttendances'])->name('attendances');
        });
        Route::resource('attendances', AttendanceController::class)->only(['show', 'destroy']);
        Route::resource('sections', InstructorSectionController::class)->only(['index', 'destroy', 'create', 'store']);
    });
});

require __DIR__ . '/auth.php';
