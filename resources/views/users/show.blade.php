@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-4">
        <img src="" class="img-thumbnail avatar" />
    </div>
    <div class="col-8">
        <h3>{{ $user->name }}</h3>
        <div class="mb-2 mt-2">
            @auth
            <form method="POST" action="{{route('users.comments.store',['post'=>$post ->id])}}">
                @csrf

                <div class="form-group">
                    <textarea type="text" name="content" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Add comment</button>
            </form>
            @error('content')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
            @else
            <a href="{{ route('login') }}">Sign-in</a> to post comments!
            @endauth
        </div>
        <hr />
    </div>
</div>
@endsection