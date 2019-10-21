<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase {
    use RefreshDatabase;

    /** @test */
    public function a_project_owner_can_invite_users() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $invitedUser = factory('App\User')->create();

        $this->post("{$project->path()}/invitations", ['email' => $invitedUser->email])
            ->assertRedirect($project->path());

        $project->fresh();

        $this->assertTrue($project->members->contains($invitedUser));
    }

    /** @test */
    public function the_invited_email_address_must_be_a_valid_account() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post("{$project->path()}/invitations", ['email' => 'notauser@email.com'])
            ->assertSessionHasErrors(['email' => 'The user you are inviting must have a Birdboard account']);
    }

    /** @test */
    public function invited_users_may_update_project_details() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->invite($anotherUser = factory(User::class)->create());

        $this->signIn($anotherUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'New task']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function non_owner_may_not_invite_users() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $user = factory('App\User')->create();

        $this->actingAs($user)
            ->post("{$project->path()}/invitations",
                ['email' => 'someemail@example.com'])
            ->assertStatus(403);
    }
}
