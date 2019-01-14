<div class="card mt-2 mb-2">
    <div class="card-header lavel">
        <h5 class="flex">
            <a href="#">
                {{$reply->owner->name}}
            </a> said
            {{$reply->created_at->diffForHumans()}}...
        </h5>
        <div>
            <form method="POST" action="/replies/{{$reply->id}}/favorites">
                @csrf
                <button class="btn {{$reply->isFavorited() ? 'disabled':''}}">
                    {{$reply->favorites()->count()}} {{str_plural('Favorite',$reply->favorites()->count())}}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>