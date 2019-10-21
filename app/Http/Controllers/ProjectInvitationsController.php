<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Http\Requests\ProjectInvitationRequest;

/**
 * Class ProjectInvitationsController
 *
 * @package App\Http\Controllers
 */
class ProjectInvitationsController extends Controller {

    /**
     * @param \App\Project $project
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Project $project, ProjectInvitationRequest $request) {
        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
