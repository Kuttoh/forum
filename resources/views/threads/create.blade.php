@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create A New Thread</div>

                    <div class="card-body">

                        <form method="post" action="/threads">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input name="title" type="text" class="form-control" id="title">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" id="body" name="body" rows="8"></textarea>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
