<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->limitChars('content', 200)
            ->paginate(4);

        return inertia('Notes/Index', [
            'notes' => $notes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->limitChars('content', 200)
            ->paginate(4);

        return inertia('Notes/Create', [
            'notes' => $notes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        //TODO: Add validation rules in StoreNoteRequest
        $note = Note::create([
            'title' => $request->title,
            'slug' => str($request->title)->slug(),
            'content' => Purify::clean($request->content),
            'user_id' => Auth::user()->id,
        ]);

        return to_route('notes.index')->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->limitChars('content', 200)
            ->paginate(4);

        return inertia('Notes/Show', [
            'notes' => $notes,
            'note' => $note,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        //TODO: Add validation rules in UpdateNoteRequest
        $note->update([
            'title' => $request->title,
            'slug' => str($request->title)->slug(),
            'content' => Purify::clean($request->content),
        ]);

        return to_route('notes.index')->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Ensure the authenticated user is the owner of the note
        $note->delete();

        return to_route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
