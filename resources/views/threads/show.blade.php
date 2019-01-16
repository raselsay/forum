@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="lavel">
                            <span class="flex">
                               <a href="{{route('profile',$thread->creator->name)}}">{{$thread->creator->name}}</a> posted:
                               {{$thread->title}}
                            </span>
                            @can('update',$thread)
                                <form  method="post" action="{{ $thread->path() }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                       {{$thread->body}}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{$replies->links()}}

                @if(auth()->check())
                    <form method="post" action="{{$thread->path()}}/replies">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" class="form-control" cols="30" rows="5" placeholder="Have something to say "></textarea>
                        </div>
                        <button class="btn btn-default">Reply</button>
                    </form>
                @else
                    <p class="text-center mt-3">Please <a href="{{route('login')}}">sign in</a> to participate in this discussion</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        this thread was published  {{ $thread->created_at->diffForHumans() }} by
                        <a href="{{route('profile',$thread->creator->name)}}">{{ $thread->creator->name }}</a> , and currently has
                        {{$thread->replies_count}} {{ str_plural('comment',$thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
