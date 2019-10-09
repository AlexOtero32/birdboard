<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function path()
    {
        return "/tasks/{$this->id}";
    }

    public function complete()
    {
        $this->update(['completed' => true]);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->project->recordActivity('created_task');
        });

        static::updated(function ($task) {
            if (!$task->completed) return;

            $task->project->recordActivity('completed_task');
        });
    }
}
