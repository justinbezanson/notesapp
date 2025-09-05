<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return inertia('Notes/Index', [
            'notes' => $notes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

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
    public function show(Request $request, Note $note)
    {
        $notes = Note::query()
            ->where('user_id', Auth::user()->id)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

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
        $this->authorize('update', $note);

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
        $this->authorize('delete', $note);

        try {
            $note->delete();
        } catch (\Exception $e) {
            \Illuminate-›Support\Facades\Log::error('Error deleting note: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete note.']);
        }

        return to_route('notes.index')->with('success', 'Note deleted successfully.');
    }

    public function clone(Note $note)
    {
        $this->authorize('create', Note::class);

        $newNote = $note->replicate();
        $newNote->title = $note->title . ' (Copy)';
        $newNote->slug = str($newNote->title)->slug();
        $newNote->created_at = now();
        $newNote->updated_at = now();
        $newNote->save();

        return to_route('notes.show', $newNote)->with('success', 'Note cloned successfully.');
    }
}
