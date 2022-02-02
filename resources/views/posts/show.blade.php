@extends('layouts.app')
@section('title',$post->title)
@section('content')
<div class="row">
    <div class="col-8">
    @if($post->image)
        <div style="background-image: url('{{ $post->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
            <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
        @else
            <h1>
        @endif
            {{ $post->title }}
            <x-badge type="NEW" />
        @if($post->image)    
            </h1>
        </div>
        @else
            </h1>
        @endif

        <p>{{ $post['content'] }}</p>
        <p>Added {{$post->created_at->diffForHumans()}}: {{$post->user->name}}</p>
       {{Storage::url($post->image->path)}}
        <!-- {{(new Carbon\Carbon())->diffInMinutes($post->created_at) }} -->
            <!-- @tags(['tags']=>$post->tags])@endtags -->
         <!-- <img src="{{Storage::url($post->image->path)}}"/> -->
         <!-- <img src="{{$post->image->url()}}"/> -->

        @component('components.tags',['tags'=>$post->tags])
        @endcomponent

        <h4>Comments</h4>
        @include('comments._form') 
        @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }}
            
        </p>
        <p class="text-muted">
            added {{ $comment->created_at->diffForHumans() }}
            :{{$comment->user->name}}
        </p>
        @empty
        <p>No comments yet!</p>
        @endforelse
    </div>
    <div class="col-4">
       @include('posts._activity')
    </div>
</div>


@endsection