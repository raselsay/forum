<div id="reply-{{ $reply->id }}" class="card mt-2 mb-2">
    <div class="card-header lavel">
        <h5 class="flex">
            <a href="{{ route('profile',$reply->owner->name) }}">
                {{$reply->owner->name}}
            </a> said
            {{$reply->created_at->diffForHumans()}}...
        </h5>
        <div>
            <form method="POST" action="/replies/{{$reply->id}}/favorites">
                @csrf
                <button class="btn"  {{$reply->isFavorited() ? 'disabled':''}}>
                    {{$reply->favorites_count}} {{str_plural('Favorite',$reply->favorites_count)}}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
    @can('update',$reply)
    <div class="card-footer">
        <form action="/replies/{{$reply->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
    </div>
    @endcan
</div>