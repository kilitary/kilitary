@extends('layouts.app')

@section('content')
  <a href="/"><-index</a><br/>
  <div class="container page-content">
    <form method="post" action="/update/{{$page->code}}">
      {{csrf_field()}}
      <div>
        <label class="edit-label" for="header">header</label>
        <input name="header" style="margin-bottom:10px;width:500px" placeholder="example: my super header"
               value="{{$page->header}}">
      </div>
      <div>
        <label class="edit-label" for="cost">cost (in USD)</label>
        <input name="cost" style="margin-bottom:10px;width:500px" placeholder="example: 1.95"
               value="{{$page->cost}}">
      </div>
      <div>
        <label class="edit-label" for="content">content</label>
        <textarea name="content" placeholder="water is wet"
                  style="width:100%;height:700px">{{\Tools::br2nl($page->content)}}</textarea>
      </div>
      <h2 class="page-header">
        <button>extend</button>
      </h2>
      <li>
        <a class="bottom-line alignnmiddle" href="/">ret()
      </li>
    </form>
  </div>


  </div>

@endsection
