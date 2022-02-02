 @extends('layouts.app')
@section('title','Posts Page')
@section('content')
<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
        <p>
        <h3>
            @if($post->trashed())
            <del>
                @endif
                <a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                @if($post->trashed())
            </del>
            @endif
        </h3>

        <p class="text-muted">
            Added {{ $post->created_at->diffForHumans() }}
            by {{ $post->user->name }}
        </p>
        <!-- @tags(['tags' => $post->tags])@endtags -->
        @foreach ($post->tags as $tag)
         <div style="color:green">{{ $tag->name }}</div>
        @endforeach


        @if($post->comments_count)
        <p>{{ $post->comments_count }} comments</p>
        @else
        <p>No comments yet!</p>
        @endif

        @can('update', $post)
        <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
            Edit
        </a>
        @endcan

        {{-- @cannot('delete', $post)
                <p>You can't delete this post</p>
            @endcannot --}}

        @if(!$post->trashed())
        @can('delete', $post)
        <form method="POST" class="fm-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete!" class="btn btn-primary" />
        </form>
        @endcan
        @endif
        </p>
        @empty
        <p>No blog posts yet!</p>
        @endforelse
    </div>
    <div class="col-4">
       @include('posts._activity')
    </div>
</div>

@endsection