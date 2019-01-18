@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="page-header">
                <h1>
                    {{ $profileUser->name }}
                </h1>
            </div>

            @foreach($activities as $data=>$activity)
                <div class="page-item">
                    {{$data}}
                </div>
                @foreach($activity as $record)
                    @if( view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}",['activity'=>$record])
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endsection