<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase {

    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);

            $this->assertEquals(null, $activity->changes);
        });
    }

    /**
     * @test
     */
    public function updating_a_project() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $originalTitle = $project->title;

        $project->update(['title' => 'Nuevo título']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Nuevo título'],
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /**
     * @test
     */
    public function creating_a_new_task() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Test task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf('App\Task', $activity->subject);
            $this->assertEquals('Test task', $activity->subject->body);
        });

        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function completing_a_task() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Test task');

        $this->patch($project->tasks[0]->path(), [
            'body' => 'Updated',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf('App\Task', $activity->subject);
            $this->assertEquals('Updated', $activity->subject->body);
        });

        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function incompleting_a_task() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Test task');

        $this->patch($project->tasks[0]->path(), [
            'body' => 'Updated',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'Updated',
            'completed' => false,
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function deleting_a_task() {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project->addTask('Test task');

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
