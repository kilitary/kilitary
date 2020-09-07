@extends('layouts.app')

@section('content')
    <div class="container">
        success: {{$success}}<br/><a href='/su/{{$shortUrl->short}}'>https://kilitary.ru/su/{{$shortUrl->short}}</a>
        to {{$shortUrl->long}}
    </div>
    <script>
        setTimeout(function() {
            document.location.href = '/su/{{$shortUrl->short}}';
        }, 15000);
    </script>
@endsection
