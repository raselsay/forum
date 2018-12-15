@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}
                    </div>
                    <div class="card-body">
                       {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <form method="post" action="{{$thread->path()}}/replies">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" class="form-control" cols="30" rows="5" placeholder="Have something to say "></textarea>
                    </div>
                    <button class="btn btn-default">Reply</button>
                </form>
            </div>
        </div>
            @else
            <p class="text-center mt-3">Please <a href="{{route('login')}}">sign in</a> to participate in this discussion</p>
        @endif
    </div>
@endsection
