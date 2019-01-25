<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;
    protected $guarded=[];

    protected $with=['channel'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount',function ($builder){
            $builder->withCount('replies');
        });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });
    }

    /**
     * Show a single thread
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * a thread belongTo Channel
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * a thread Has Many  a reply
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * a thread belongsTo a creator
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Add reply to the thread
     * @param $reply
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }
}
