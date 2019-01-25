<reply :attributes="{{ $reply }}" inline-template>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" id="" cols="30" rows="2" class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update">update</button>
                <button class="btn btn-link btn-sm" @click="editing= false">cancel</button>
            </div>
            <div v-else v-text="body">
            </div>
        </div>
        @can('update',$reply)
            <div class="card-footer lavel">
                <button class="btn btn-secondary btn-sm mr-2" @click="editing=true">Edit</button>
                <button type="submit" class="btn btn-danger btn-sm" @click="destroy">Delete</button>
                {{--<form action="/replies/{{$reply->id}}" method="POST">--}}
                    {{--@csrf--}}
                    {{--@method('DELETE')--}}
                    {{--<button type="submit" class="btn btn-danger btn-sm">Delete</button>--}}
                {{--</form>--}}
            </div>
        @endcan
    </div>
</reply>