@extends('layouts.app')
@section('title','Contact Page')
@section('content')
<h1>CONTACT PAGE</h1>

@can('home.secret')
 <p>Special Contact Details</p>
@endcan
@endsection