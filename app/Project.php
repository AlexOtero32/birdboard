<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * @return HasMany
     */
    public function tasks() {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the project activity.
     *
     * @return HasMany
     */
    public function activity() {
        return $this->hasMany(Activity::class)->latest();
    }

}
