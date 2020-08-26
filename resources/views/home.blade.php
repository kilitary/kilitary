@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>hello {{ $info }}</h2>
        @if (isset($gdiSelected) && $gdiSelected)
            <h3> global defense initiative selected (in {{ mt_rand(0,1) ? 'case' : 'state' }}  of {{$chanceOf}})</h3>
        @else
            <h3> brotherhood of nod selected (in {{ mt_rand(0,1) ? 'case' : 'state' }} of {{$chanceOf}})</h3>
        @endif
    </div>
@endsection
