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

@section('scripts')
    <script>
        $(function() {
            for(let i = 0; i < rando(2, 8); i++) {
                setTimeout(function() {
                    var audio = new Audio('/audio/HALTSND.mp3');
                    audio.play();
                }, rando(400, 1300));

            }
        });
    </script>
@endsection

