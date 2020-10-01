@extends('layouts.app')

@section('content')
    <div class="container page-content">
        This page
        @if (isset($code))
            ({{$code}})
        @endif
        was deleted.
    </div>
@endsection
