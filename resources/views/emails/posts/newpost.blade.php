<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p>Hi {{ $post->user->name }}</p>

<p>
    Someone has posted blogpost
    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
        {{ $post->title }}
    </a>
    Embed Image:
    <img src="{{$message->embed(storage_path('app/public').'/prof1.jpeg') }}" />
</p>

<hr/>


<p>
    "{{ $post->content }}"
</p>
