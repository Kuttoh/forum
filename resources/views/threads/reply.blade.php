<div class="card" style="margin-bottom:10px">
    <div class="card-header">

        <div class="level">
            <h6 class="flex">
                <a href="#">{{$reply->owner->name}}
                </a> said {{ $reply->created_at->diffForHumans() }}...
            </h6>

            <form method="post" action="/replies/{{ $reply->id }}/favorites">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled': '' }}>
                    {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count )}}
                </button>
            </form>
        </div>

    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
