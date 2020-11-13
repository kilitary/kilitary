@extends('layouts.app')

@section('content')
    <div>
        <h3>Done. Your purchase id: {{ hash('crc32', $id) }}</h3>
        <a href="/">->ret()</a>
    </div>
@endsection
