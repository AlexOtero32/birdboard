<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase {

    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_create_projects() {
        $attributes = factory('App\Project')->raw(['owner_id' => null]);

        $this->post('/projects', $attributes)->assertRedirect('/login');

        $this->get('/projects/create')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function guests_cannot_view_projects_list() {
        $this->get('/projects')->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function guests_cannot_view_single_projects() {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function guests_cannot_edit_projects() {
        $project = factory('App\Project')->create();

        $this->get("{$project->path()}/edit")->assertRedirect('/login');
    }

    /**
     * @test
     *
     */
    public function a_user_can_create_a_project() {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here',
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /**
     * @test
     */

    public function a_project_requires_a_title() {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description() {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /**
     * @test
     */
    public function an_user_can_view_their_project() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test
     */
    public function an_user_cannot_view_the_projects_of_others() {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function an_user_cannot_update_the_projects_of_others() {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path(), [
            'notes' => 'Hello world',
        ])->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_project_belongs_to_an_owner() {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_project() {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get("{$project->path()}/edit")->assertOk();

        $attributes = [
            'title' => 'Nuevo título',
            'description' => 'Nueva descripcion',
            'notes' => 'Hello world',
        ];

        $this->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /**
     * @test
     */
    public function a_user_can_update_a_projects_notes() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get("{$project->path()}/edit")->assertOk();

        $attributes = [
            'notes' => 'Hello world',
        ];

        $this->patch($project->path(), $attributes)
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_delete_a_project() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function unauthorized_users_cannot_delete_projects() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        Auth::logout();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_view_all_projects_they_have_been_invited_to_on_their_dashboard() {
        $project = tap(factory('App\Project')->create())->invite($this->signIn());

        $this->get('/projects')
            ->assertSee($project->title);
    }
}
