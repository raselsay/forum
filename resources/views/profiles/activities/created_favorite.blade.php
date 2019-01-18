@component('profiles.activities.activity')
    @slot('header')
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $profileUser->name }} : favorited to reply.
        </a>
{{--        <a href="{{ $activity->favorited->thread->path() }}">""</a>--}}
    @endslot
    @slot('body')
        {{$activity->subject->favorited->body}}
    @endslot
@endcomponent