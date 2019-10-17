<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class ProjectTasksController
 *
 * @package App\Http\Controllers
 */
class ProjectTasksController extends Controller {
    /**
     * @param Project $project
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Project $project) {
        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * @param Task $task
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Task $task) {
        $this->authorize('update', $task->project);

        $task->update(request()->validate(['body' => 'required']));

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($task->project->path());
    }
}
