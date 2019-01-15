<div class="card mt-2 mb-2">
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
</div>