@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post" action="/page/{{$code}}">
            {{ csrf_field() }}
            <h3>Header</h3>
            <input class="marginleft" name="header">
            <h3>Content <span class="smallcaps">(markdown supported)</span></h3>
            <textarea required class="marginleft" style='width:100%;height: 200px;' name="content"></textarea>
            <button class="marginleft">create!</button>
        </form>

    </div>
@endsection
