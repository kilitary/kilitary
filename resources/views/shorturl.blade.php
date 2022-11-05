@extends('layouts.app')

@section('content')
  <div class="container">
    <h2><a href="{{env('APP_URL')}}/us/{{$shortUrl->short}}">{{env('APP_URL')}}/us/{{$shortUrl->short}}</a></h2>
    to
    <h2>{{$shortUrl->long}}</h2>
    <br/>
    stable: {{$success}}<br/>
    system: url shortner v 4.06.153.34.01c<br/>
    <div class="links"><a href='/command/sync?{{request()->path()}}'>sync</a></div>

    <br/>
    <a class="bottom-line alignnmiddle" href="/">ret()</a>
  </div>
  <script>
    setTimeout(function() {
      document.location.href = '/us/{{$shortUrl->short}}';
    }, 15000);
  </script>
@endsection
