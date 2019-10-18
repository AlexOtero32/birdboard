<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase {

    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_has_projects() {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_available_projects() {
        $john = $this->signIn();

        factory('App\Project')->create(['owner_id' => $john->id]);

        $this->assertCount(1, $john->availableProjects());

        $alex = factory('App\User')->create();
        $nick = factory('App\User')->create();

        $project = tap(factory('App\Project')->create(['owner_id' => $alex->id]))
            ->invite($nick);

        $this->assertCount(1, $john->availableProjects());

        $project->invite($john);

        $this->assertCount(2, $john->availableProjects());
    }
}
