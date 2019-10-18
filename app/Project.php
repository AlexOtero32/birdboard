<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Project
 *
 * @package App
 */
class Project extends Model {
    use RecordsActivity;

    /**
     * @var array
     */
    public $old = [];
    /**
     * @var array
     */
    protected $guarded = [];


    /**
     * The path to the project.
     *
     * @return string
     */
    public function path() {
        return "/projects/{$this->id}";
    }


    /**
     * The user relationship.
     *
     * @return BelongsTo
     */
    public function owner() {
        return $this->belongsTo(User::class);
    }

    /**
     * Add a task to the project.
     *
     * @param string $body
     *
     * @return Model
     */
    public function addTask($body) {
        $task = $this->tasks()->create(compact('body'));

        return $task;
    }

    /**
     * Get the project tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the project activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity() {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * @param \App\User $user
     */
    public function invite(User $user) {
        return $this->members()->attach($user);
    }

    public function members() {
        return $this->belongsToMany(User::class, 'project_members')
            ->withTimestamps();
    }

}
