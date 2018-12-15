<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function index(){
        $threads = Thread::latest()->get();
        return view('threads.index',compact('threads'));
    }
}
