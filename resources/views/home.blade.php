@extends('layouts.app')

@section('content')
    <div class="container">
        hello {{ $info }}
        @if ($gdiSelected)
            <h3> global defense initiative selected </h3>
        @endif
    </div>
@endsection
