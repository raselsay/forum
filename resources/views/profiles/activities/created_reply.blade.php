@component('profiles.activities.activity')
  @slot('header')
      {{ $profileUser->name }} : replied to
      <a href="{{ $activity->subject->thread->path() }}">"{{ $activity->subject->thread->title }}"</a>
  @endslot
  @slot('body')
      {{$activity->subject->body}}
  @endslot
@endcomponent