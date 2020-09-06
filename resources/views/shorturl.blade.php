@extends('layouts.app')

@section('content')
    <div class="container">
        success/fail: <a href='/su/{{$shortUrl->short}}'>https://kilitary.ru/su/{{$shortUrl->short}}</a>
        to {{$shortUrl->long}}
    </div>
@endsection
