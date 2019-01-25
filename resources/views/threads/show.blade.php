@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count  }}" inline-template>
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

                    <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>
                    {{--@foreach($replies as $reply)--}}
                    {{--@include('threads.reply')--}}
                    {{--@endforeach--}}

                    {{--{{$replies->links()}}--}}
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            this thread was published  {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{route('profile',$thread->creator->name)}}">{{ $thread->creator->name }}</a> , and currently has
                            <span v-text="repliesCount"></span> {{ str_plural('comment',$thread->replies_count) }}.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </thread-view>
@endsection
