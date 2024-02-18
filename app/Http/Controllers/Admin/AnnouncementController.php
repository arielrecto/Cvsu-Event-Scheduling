<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $announcements = Announcement::latest()->paginate(10);

        return view('users.admin.announcement.index', compact(['announcements']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Announcement::create([
            'title' => $request->title,
            'description' => $request->description
        ]);


        return back()->with(['message' => 'Announcement is Added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $announcement = Announcement::find($id);

        return view('users.admin.announcement.show', compact(['announcement']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $announcement = Announcement::find($id);

        return view('users.admin.announcement.edit', compact(['announcement']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $announcement = Announcement::find($id);

        if($request->description != '<p><br></p>'){
            $announcement->update([
                'description' => $request->description
            ]);
        }

        $announcement->update([
            'title' => $request->title ?? $announcement->title
        ]);

        return back()->with(['message' => 'Announcement Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::find($id);

        $announcement->delete();


        return back()->with(['message' => 'Announcement Data Deleted']);
    }
}
