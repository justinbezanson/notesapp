<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        Session::start();
        $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ]);
    }

    public function test_notes_index_page_is_displayed(): void
    {
        $response = $this->get(route('notes.index'));

        $response->assertOk();
    }

    public function test_a_note_can_be_created(): void
    {
        $response = $this->post(route('notes.store'), [
            'title' => 'Test Note',
            'content' => 'This is a new test note.',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', [
            'title' => 'Test Note',
            'content' => 'This is a new test note.',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_a_note_can_be_updated(): void
    {
        $note = Note::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('notes.update', $note), [
            'title' => 'Updated Note',
            'content' => 'This note has been updated.',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => 'Updated Note',
            'content' => 'This note has been updated.',
        ]);
    }

    public function test_a_note_can_be_deleted(): void
    {
        $note = Note::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('notes.destroy', $note));

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }

    public function test_user_cannot_update_other_users_note(): void
    {
        $otherUser = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->put(route('notes.update', $note), [
            'title' => 'Attempted Update',
            'content' => 'Attempted update by another user.',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
        ]);
    }

    public function test_user_cannot_delete_other_users_note(): void
    {
        $otherUser = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->delete(route('notes.destroy', $note));

        $response->assertForbidden();
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_notes(): void
    {
        auth()->logout();

        $response = $this->get(route('notes.index'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('notes.store'), ['title' => 'Test', 'content' => 'Test']);
        $response->assertRedirect(route('login'));
    }
}
