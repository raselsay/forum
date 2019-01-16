<?php
/**
 * Created by PhpStorm.
 * User: rasel
 * Date: 1/16/19
 * Time: 11:13 AM
 */

namespace App;


use phpDocumentor\Reflection\Types\Static_;

trait RecordActivity
{

    protected static function bootRecordActivity()
    {
        if (auth()->guest()) return;
        foreach (static::getRecordEvents() as $event)
        {
            // static::created ( function( $thread ( $thread model use form $event object ) ) use ($event) )
            static::$event(function ($model) use ($event){
                $model->recordActivity($event);
            });
        }
    }
    protected static function getRecordEvents()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id'=> auth()->id(),
            'type'=> $this->getActivityType($event)
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity','subject');
     }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}