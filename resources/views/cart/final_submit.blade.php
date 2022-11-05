@extends('layouts.app')

@section('content')
  <div>
    <h3>Done. Your purchase id: {{ $crc32b }}</h3>
    <a href="/">->ret()</a>
  </div>
@endsection
