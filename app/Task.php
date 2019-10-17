<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Task
 *
 * @package App
 */
class Task extends Model {
    use RecordsActivity;

    /**
     * Recordable events.
     *
     * @var array
     */
    protected static $recordableEvents = ['created', 'deleted'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $touches = ['project'];

    /**
     * @var array
     */
    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * The project for this task.
     *
     * @return BelongsTo
     */
    public function project() {
        return $this->belongsTo('App\Project');
    }

    /**
     * @return string
     */
    public function path() {
        return "/tasks/{$this->id}";
    }

    /**
     * Incompletes the task.
     */
    public function incomplete() {
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');
    }

    /**
     * Completes the task.
     */
    public function complete() {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }
}
