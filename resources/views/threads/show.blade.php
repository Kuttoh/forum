@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header">

                        <a href="">{{ $thread->creator->name }}</a> posted: {{ $thread->title }}</div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if(auth()->check())

                    <form method="post" action="{{ $thread->path(). '/replies' }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                        <textarea name="body" id="body" rows="5" class="form-control"
                                  placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">Sign In</a> to participate in this
                        discussion
                    </p>
                @endif
            </div>


            <div class="col-md-4">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header">Thread Meta-Information</div>
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>, and has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
