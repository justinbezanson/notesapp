<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->withSession([]);
    }

    public function test_projects_page_is_displayed(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertOk();
    }

    public function test_project_can_be_created(): void
    {
        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => 'This is a test project.',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'description' => 'This is a test project.',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_project_can_be_updated(): void
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->put(route('projects.update', $project), [
            'title' => 'Updated Project',
            'description' => 'This is an updated test project.',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Project',
            'description' => 'This is an updated test project.',
        ]);
    }

    public function test_project_can_be_deleted(): void
    {
        $project = Project::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_user_cannot_update_other_users_project(): void
    {
        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->put(route('projects.update', $project), [
            'title' => 'Attempted Update',
            'description' => 'Attempted update by another user.',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => $project->title,
            'description' => $project->description,
        ]);
    }

    public function test_user_cannot_delete_other_users_project(): void
    {
        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertForbidden();
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_projects(): void
    {
        auth()->logout();

        $response = $this->get(route('projects.index'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('projects.store'), ['title' => 'Test']);
        $response->assertStatus(302);
    }
}
