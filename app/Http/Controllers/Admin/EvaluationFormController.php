<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\EvaluationForm;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvaluationFormController extends Controller
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
    public function create($eventID)
    {

        $event = Event::find($eventID);

        return view('users.admin.events.evaluation-form.create', compact(['event']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = json_decode($request->evaluation_form);

        if($formData->title === null && count($formData->fields) === 0){
            return back()->with(['error' => 'Title and fields is Required']);
        }

        if($formData->title === null){
            return back()->with(['error' => 'Title is Required']);
        }

        if(count($formData->fields) === 0){
            return back()->with(['error' => 'fields is Required']);
        }


        EvaluationForm::create([
            'event_id' => $request->event_id,
            'form' => $request->evaluation_form
        ]);



        return to_route('events.show', ['event' => $request->event_id])->with(['message' => 'form is added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
