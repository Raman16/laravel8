<!-- <div style="color:red">Partials:</div>
<div>{{$post['title']}}</div>
<div>remaning:{{$loop->remaining}}</div>
<div>count:{{$loop->count}}</div>
<div>index:{{$loop->index}}</div> -->

<h3>
    
    {{$post->title}}
    <a href="{{route('posts.show',['post'=>$post->id])}}" class="btn btn-primary">
        SHOW
    </a>
</h3>
<div class="mb-3">
    <p class="text-muted">
        Added {{ $post->created_at->diffForHumans() }}
        by {{ $post->user->name }}
    </p>

    @if($post->comments_count)
    <p>{{$post->comments_count}} Comments </p>
    @else
      No Comments Yet!
    @endif

    @auth
      @can('update',$post)
        <a href="{{route('posts.edit',['post'=>$post->id])}}" class="btn btn-primary">
          EDIT
       </a>
      @endcan
     @endauth

    @auth
      @can('delete',$post)
      <form class="d-inline" action="{{route('posts.destroy',['post'=>$post->id])}}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="DELETE!" class="btn btn-primary">
      </form>
      @endcan
    @endauth
</div>