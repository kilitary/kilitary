@extends('layouts.app')

@section('content')
    <div class="container page-content">
        This page
        @if (isset($code))
            ({{$code}})
        @endif
        was deleted.

        <div class="topheadmargin page-content">
            <a href="/">return back</a>
        </div>
    </div>
@endsection
