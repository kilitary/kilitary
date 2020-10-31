@extends('layouts.app')

@section('content')
    <a href="/"><-index</a> Wind: {{mt_rand(11, 22)}}<br/>
    <div class="container page-content">

        <h2 class="page-header">{{$header}}</h2>
        <div class="content-container">
            {!! nl2br($content)!!}
        </div>
        <div class="content-keys">
            {{$keys}}
        </div>
        <div class="page-country">
                <span data-pt-placement="corner-right-top" data-pt-width='1200' data-pt-scheme="leaf"
                      data-pt-classes="protip-mine"
                      data-pt-title="<pre class='protip-mine'>{{\App\Models\Tools::ipInfo($ip)}}</pre>"
                      class="ip-info-page protip"
                >Connection<-
                </span>
        </div>

        <h2 class="page-footer"></h2>
        @if (isset($comments))
            @foreach ($comments as $comment)
                <div class="comment">
                    <div class="comment-date">
                        <img data-pt-placement="corner-right-top" data-pt-width='1200' data-pt-scheme="leaf"
                             data-pt-classes="protip-mine"
                             data-pt-title="<pre class='protip-mine'>{{\App\Models\Tools::ipInfo($comment['ip'])}}</pre>"
                             class="comment-img protip" src="/images/comp.png"
                        > {{$comment['username']}}  {{ $comment['created_at']}}
                        @if ($comment['ip'] == request()->ip()|| \App\Models\Tools::IsAdmin())
                            <a href="/comment/{{$comment['id']}}/delete"><img
                                    style='position:relative;top:2px;width:10px;height: 10px;'
                                    src="/images/delete.png"> </a>
                            <a href="/comment/{{$comment['ip']}}/delete-all-by-ip"><img
                                    style='position:relative;top:2px;width:14px;height: 14px;'
                                    src="/images/delete.png"> </a>
                        @endif
                    </div>

                    <div class="comment-content">
                        {!! $comment['comment'] !!}
                    </div>
                </div>
            @endforeach

        @endif
        <div class="new-comment">
            <form method="post" action="/comment/add">
                {{csrf_field()}}
                <input type="hidden" name="page_id" value="{{$page_id}}">
                <textarea name="comment" class="text-comment" required placeholder="inject en code / text"></textarea>
                <br/>
                <button class="commit-button">push comment</button>
            </form>
        </div>
        <div class="topheadmargin ">
            √iews: {{$views}} Edits: {{$edits}}
        </div>

        <div class=" page-content">
            <ul class="select-doc-future">
                <li>
                    <a class="alignnmiddle" href="/delete/{{$code}}/0">delete this killware</a>
                </li>
                <li>
                    <a class="alignnmiddle" href="/cart/add/{{$code}}">add to cart</a>
                </li>
                <li>
                    <a href="/edit/{{$code}}">extend / reformate</a>
                </li>
                <li>
                    <a class=" alignnmiddle" href="/">ret()</a>
                </li>
            </ul>
        </div>


    </div>
@endsection

@section('scripts')
    <script>
        @if (session('playAudio', false))
        $(function() {
            var audio = new Audio('{{session()->pull('playAudio')}}');
            audio.play();
        });

        @else
        $(function() {
            var audio = new Audio('/audio/ss.mp3');
            audio.play();
        });

        @endif
    </script>
@endsection

