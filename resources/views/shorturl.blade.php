@extends('layouts.app')

@section('content')
    <div class="container">
        success/fail: <a href='/su/{{$shortUrl->short}}'>https://kilitary.ru/su/{{$shortUrl->short}}</a>
        to {{$shortUrl->long}}
    </div>
    <script>
        setTimeout(function() {
            document.location.href = '{{$shortUrl->short}}';
        }, 2000)
    </script>
@endsection