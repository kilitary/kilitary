@extends('layouts.app')

@section('content')
  <div><a href="/"><img src='/images/Insert_Before.png'> </a></div>
  <div class="container">
    <form method="post" action="/comment/add">
      @csrf
      <div class='form-input'>
        <img class='title-img' src='/images/type.png'>
      </div>
      <input required class="form-input" name="type" placeholder='суки...  [текст]'>
      <div class='form-input'>
        <textarea required class="textarea-comment" name="comment" placeholder='только захотел взять свою булочку а она... [текст]'></textarea>
        <div class="textarea-bg"><img src='/images/download.png'> </div>
        <div class="smallcaps">
          (<a target=_blank href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">поддержка</a>)
        </div>
      </div>
      <div class='form-input'>
        <button class="marginleft"><img class='save-button' src='/images/save-icon.png'></button>
      </div>
    </form>
  </div>
@endsection
