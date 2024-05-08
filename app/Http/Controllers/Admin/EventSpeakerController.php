<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSpeaker;
use Illuminate\Http\Request;

class EventSpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;

        $speakers = EventSpeaker::latest()->paginate(10);


        if($search !== null){

            $speakers = EventSpeaker::where('last_name', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')->paginate(10);
        }


        return view('users.admin.event-speaker.index', compact(['speakers']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.event-speaker.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'image' => 'required|mimes:png,jpg,jpeg',
            'last_name' => 'required',
            'first_name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'valid_document' => 'required|mimes:png,jpg,jpeg',
            'occupation' => 'required',
            'description' => 'required'
        ]);





        $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/profile', $imageName, 'public');


        $documentImage = 'DCMNTS-' . uniqid() . '.' . $request->valid_document->extension();
        $valid_dir = $request->valid_document->storeAs('/document', $documentImage, 'public');



        EventSpeaker::create([
            'image' => asset('/storage/' . $dir),
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'valid_documents' =>  asset('/storage/' . $valid_dir),
            'occupation' => $request->occupation,
            'description' => $request->description
        ]);



        return to_route('events.create')->with(['message' => 'Add Speaker success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $speaker = EventSpeaker::find($id);


        return view('users.admin.event-speaker.show', compact(['speaker']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $speaker = EventSpeaker::find($id);

        return view('users.admin.event-speaker.edit', compact(['speaker']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $speaker = EventSpeaker::find($id);

        if($request->has('image')){
            $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/profile', $imageName, 'public');


            $speaker->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }

        if($request->has('valid_document')){
            $documentImage = 'DCMNTS-' . uniqid() . '.' . $request->valid_document->extension();
            $valid_dir = $request->valid_document->storeAs('/document', $documentImage, 'public');


            $speaker->update([
                'valid_documents' =>  asset('/storage/' . $valid_dir),
            ]);
        }



        $speaker->update([
            'last_name' => $request->last_name ?? $speaker->last_name,
            'first_name' => $request->first_name ?? $speaker->first_name,
            'middle_name' => $request->middle_name ?? $speaker->middle_name,
            'age' => $request->age ?? $speaker->age,
            'address' => $request->address ?? $speaker->address,
            'occupation' => $request->occupation ?? $speaker->occupation,
            'description' => $request->description ?? $speaker->description
        ]);



        return back()->with(['message' => 'Event Speaker Data Updated']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $speaker = EventSpeaker::find($id);


        $speaker->update([
            'is_archive' => true
        ]);

        // $speaker->delete();


        return back()->with(['message' => 'Event Speaker Delete Success']);
    }
}
