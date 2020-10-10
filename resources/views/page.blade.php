@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    <div class="container page-content">

        <h2 class="page-header">{{$header}}</h2>
        <div class="content-container">
            {!! $content!!}
        </div>
        <div class="page-country">Remote: {{$country}}</div>
        <h2 class="page-footer"></h2>
        @if (isset($comments))
            @foreach ($comments as $comment)
                <div class="comment">
                    <div class="comment-date">
                        <img class="comment-img" src="/images/comp.png"
                             title="{{$comment['country']}}"> {{$comment['username']}}  {{ $comment['created_at']}}
                        @if ($comment['ip'] == request()->ip()|| \App\Models\Tools::IsAdmin())
                            <a href="/comment/{{$comment['id']}}/delete"><img
                                    style='position:relative;top:2px;width:10px;height: 10px;'
                                    src="/images/delete.png"> </a>
                        @endif
                    </div>

                    <div class="comment-content">
                        {{$comment['comment']}}
                    </div>
                </div>
            @endforeach

        @endif
        <div class="new-comment">
            <form method="post" action="/comment/add">
                {{csrf_field()}}
                <input type="hidden" name="page_id" value="{{$page_id}}">
                <input name="comment" required placeholder="inject">
                <button>comment</button>
            </form>
        </div>
        <div class="topheadmargin ">
            √iews: {{$views}} Edits: {{$edits}}
        </div>

        <div class=" page-content">
            <ul class="select-doc-future">
                <li>
                    <a class=" alignnmiddle" href="/delete/{{$code}}/0">delete this info (killware/0.65$)</a>
                </li>
                <li>
                    <a class=" alignnmiddle" href="/delete/{{$code}}/1">
                        delete this article (24 writes of 1/0 per bytes in file
                        sectors (inodes)
                        23.97$)</a>
                </li>
                <li>
                    <a class=" alignnmiddle" href="/delete/{{$code}}/2">
                        delete this document (255 writes of 1/0 per bytes in file
                        sectors on TWO disks and physically destroy
                        ONE of active RAID1 disk 94.95$)</a>
                </li>
                <li>
                    <a href="/edit/{{$code}}">extend</a>
                </li>
                <li>
                    <a class=" alignnmiddle" href="/">ret</a>
                </li>
            </ul>
        </div>


    </div>

@endsection
