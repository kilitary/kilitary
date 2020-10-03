@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container">
        <form method="post" action="/page/{{$code}}">
            {{ csrf_field() }}
            <h3>Header</h3>
            <input class="marginleft" name="header">
            <h3>Content <span class="smallcaps">(markdown supported)</span></h3>
            <textarea required class="marginleft" style='width:85%;height: 200px;' name="content"></textarea>
            <div><button class="marginleft">create!</button></div>
        </form>

    </div>
@endsection
