@extends('layouts.app')

@section('content')
    <div class="container">
        success/fail: <a href='/su/{{$shortUrl->short}}'>{{$shortUrl->short}}</a>
    </div>
@endsection
