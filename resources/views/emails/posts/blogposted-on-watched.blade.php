@component('mail::message')
# Blogpost was Posted 

Hi {{user->name}}

Hello from markdown
@component('mail::button', ['url' => ''])
 Click Button
@endcomponent
<p>
    Someone has posted blogpost
    <a href="{{ route('posts.show', ['post' => $post->id]) }}">
        {{ $post->title }}
    </a>
</p>

@component('mail::panel')
{{ $post->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
