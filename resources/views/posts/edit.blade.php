@extends('layouts.app')
@section('title','Update the post')
@section('content')
<form method="POST" action="{{ route('posts.update',['post'=>$post->id]) }}" 
      enctype="multipart/form-data">
     @csrf
     @method('PUT')<!--METHOD SPOOFING-->
     @include('posts.partials.form')
     <div>
      <input type="submit" value="Update"></div>
     </div>
</form>
@endsection