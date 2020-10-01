@extends('layouts.app')

@section('content')
    <div class="container page-content">
        <h2>{{$header}}</h2>
        <div>
            @markdown($content)
        </div>

        <div class="topheadmargin smallcaps">
            Views: {{$views}}
        </div>

        <div class="page-content">
            <a href="/">reTurn back</a>
        </div>
    </div>

@endsection
