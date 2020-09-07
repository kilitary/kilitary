@extends('layouts.app')

@section('content')
    <div class="container">
        success: {{$success}}<br/>
        <h2>{{env('APP_URL')}}/su/{{$shortUrl->short}}</h2>
        to
        <h2>{{$shortUrl->long}}</h2>
        <br/>
        done.
    </div>
    <script>
        setTimeout(function() {
            document.location.href = '/su/{{$shortUrl->short}}';
        }, 15000);
    </script>
@endsection
