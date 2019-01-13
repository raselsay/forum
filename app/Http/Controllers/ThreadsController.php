<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilter;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(Channel $channel,ThreadFilter $filters){
        $threads = $this->getThreads($channel, $filters);
        if (request()->wantsJson())
        {
            return $threads;
        }
//        $threads = $threads->filter($filters)->get();
        return view('threads.index',compact('threads'));
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show',[
            'thread'=>$thread,
            'replies'=>$thread->replies()->paginate(5)
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'channel_id'=>'required|exists:channels,id',
            'title'=>'required',
            'body'=>'required'
        ]);
        $thread = Thread::create([
            'user_id'=>auth()->id(),
            'channel_id'=>request('channel_id'),
            'title'=>request('title'),
            'body'=>request('body'),
        ]);
        return redirect($thread->path());
    }

    /**
     * @param Channel $channel
     * @param ThreadFilter $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilter $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->get();
    }


}
