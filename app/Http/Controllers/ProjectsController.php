<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class ProjectsController
 *
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller {
    /**
     * @return Factory|View
     *
     */
    public function index() {
        $projects = auth()->user()->availableProjects();

        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * @param Project $project
     *
     * @return Factory|View
     * @throws AuthorizationException
     */

    public function show(Project $project) {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function store() {

        $attributes = $this->validateRequest();

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    /**
     * @return mixed
     */
    protected function validateRequest() {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:255',
            'notes' => 'nullable|min:3|max:255',
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create() {
        return view('projects.create');
    }

    /**
     * @param Project $project
     *
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project) {
        $this->authorize('update', $project);

        $attributes = $this->validateRequest();

        $project->update($attributes);

        return redirect($project->path());
    }

    /**
     * @param Project $project
     *
     * @return Factory|View
     */
    public function edit(Project $project) {
        return view('projects.edit', compact('project'));
    }

    /**
     * @param \App\Project $project
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project) {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }
}
