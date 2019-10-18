<?php


namespace App;


use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait RecordsActivity
 *
 * @package App
 */
trait RecordsActivity {
    /**
     * Old attributes for the model.
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     *
     */
    public static function bootRecordsActivity() {


        foreach ( self::recordableEvents() as $event ) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ( $event === 'updated' ) {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * @return array
     */
    public static function recordableEvents(): array {
        if ( isset(static::$recordableEvents) ) {
            return static::$recordableEvents;
        }

        return ['created', 'updated'];
    }

    /**
     * Record the activity.
     *
     * @param string $description
     */
    public function recordActivity(string $description) {
        $this->activity()->create([
            'user_id' => ($this->project ?? $this)->id,
            'description' => $description,
            'changes' => $this->getActivityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    /**
     * @return MorphMany
     */
    public function activity() {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * Get the changes that were made.
     *
     * @return array
     */
    protected function getActivityChanges() {
        if ( $this->wasChanged() ) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    /**
     * @param $description Description of the activity.
     *
     * @return string
     */
    protected function activityDescription($description): string {
        return "{$description}_" . strtolower(class_basename($this));
    }
}
