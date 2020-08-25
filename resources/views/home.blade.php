@extends('layouts.app')

@section('content')
    <div class="container">
        hello {{ $info }}
        @if ($gdiSelected)
            <h3> global defense initiative selected (in chance of {{$chanceOf}}</h3>
        @endif
    </div>
@endsection
