@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{env('APP_URL')}}/us/{{$shortUrl->short}}</h2>
        to
        <h2>{{$shortUrl->long}}</h2>
        <br/>
        stable: {{$success}}<br/>
        system: url shorter v 0.00000000000001a
    </div>
    <script>
        setTimeout(function() {
            document.location.href = '/us/{{$shortUrl->short}}';
        }, 15000);
    </script>
@endsection
