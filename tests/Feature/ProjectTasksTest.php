<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post("{$project->path()}/tasks", ['body' => 'Lorem ipsum']);

        $this->get($project->path())
            ->assertSee('Lorem ipsum');
    }

    /**
     * @test
     */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $attributes = factory('App\Project')->raw(['body' => '']);

        $this->post("{$project->path()}/tasks", $attributes)
            ->assertSessionHasErrors('body');
    }
}