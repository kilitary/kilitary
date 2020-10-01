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

        <div class="topheadmargin page-content">
            <a href="/delete/{{$code}}">DELETE & ERASE THIS DOC</a><br/>
            <a href="/">return back</a>
        </div>
    </div>

@endsection
