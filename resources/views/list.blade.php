@extends('layouts.app')

@section('content')
    <div class="container">
        @dump($list)
        @foreach ($list as $key => $item)
            <span>{{ $key }}</span>: <span>{{ $item }}</span>
        @endforeach
    </div>
@endsection
