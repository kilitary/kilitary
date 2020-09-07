@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{env('APP_URL')}}/su/{{$shortUrl->short}}</h2>
        to
        <h2>{{$shortUrl->long}}</h2>
        <br/>
        will be deleted: {{$success}}
    </div>
    <script>
        setTimeout(function() {
            document.location.href = '/su/{{$shortUrl->short}}';
        }, 15000);
    </script>
@endsection
