@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container page-content">
        <form method="post" action="/update/{{$page->code}}">
            {{csrf_field()}}
            <h2 class="page-header">{{$page->header}}</h2>
            <div>
                <textarea name="content" style="width:100%;height:700px">{{$page->content}}</textarea>
            </div>
            <h2 class="page-header">
                <button>extend</button>
            </h2>
            <li>
                <a class="topheadmargin alignnmiddle" href="/">return</a>
            </li>
        </form>
    </div>


    </div>

@endsection
