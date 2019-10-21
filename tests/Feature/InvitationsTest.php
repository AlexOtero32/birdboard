<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function a_project_owner_can_invite_a_user() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->invite($anotherUser = factory(User::class)->create());

        $this->signIn($anotherUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'New task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
