@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($list as $key => $item)
            <div class="list-item-container">
                <div class="list-key">{{ $key }}</div>
                <div class="list-item">{!! $item !!}</div>
            </div>
        @endforeach
    </div>
@endsection
