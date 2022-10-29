@extends('layouts.app')

@section('content')
  {!! $post->content !!}
  <a href='{{$post->url}}'>{{$post->title}}</a>
@endsection
