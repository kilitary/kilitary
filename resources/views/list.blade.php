@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($list as $key => $item)
            <div class="list-item-container">
                <span class="list-key">{{ $key }}</span>
                <span class="list-item">{!! $item !!}</span>
            </div>
        @endforeach
    </div>
@endsection
