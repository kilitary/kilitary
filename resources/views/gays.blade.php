@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container page-content">
        @foreach ($gays as $gay)
            <div>
                {{$gay->ip}}: {{$gay->reason}}
            </div>
        @endforeach

    </div>

@endsection
