@extends('layouts.app')

@section('content')

  @include('schema.ldjson', ['page' => $page, 'comments' => $comments])

  <a href="/"><-index</a> Wind: {{mt_rand(11, 221)}}<br/>
  <div class="container page-content">

    <h2 class="page-header">{{$header}}</h2>

    <div class="content-container">
      {!! nl2br($content)!!}
    </div>
    <div class="content-keys">
      {{$keys}}
    </div>
    <div class="page-country">
                <span data-pt-placement="corner-right-top" data-pt-width='1200' data-pt-scheme="white"
                      data-pt-title="<pre class='protip-mine'>{{\Tools::ipInfo($ip)}}</pre>"
                      class="ip-info-page protip"
                >Connection<-</span>
      <span>Cost: ${{$page->cost}}</span>

      <div class="social-buttons">
                <span class="social-twitter"><a data-size="small" class="twitter-share-button"
                                                href="https://twitter.com/intent/tweet?hashtags=kilitary,deconf,x25&via=router&text=kilitary.ru make out ">
                Tweet</a>
                    </span>

        <span class="fb-share-button social-facebook" data-href="{{request()->fullUrl()}}"
              data-layout="button_count"
              data-size="small"><a target="_blank"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(request()->fullUrl())}}&src=sdkpreparse"
                                   class="fb-xfbml-parse-ignore">share</a></span>
      </div>

    </div>

    <h2 class="page-footer"></h2>
    @if (isset($comments))
      @foreach ($comments as $comment)
        <div class="comment">
          <div class="comment-date">
            <img data-pt-placement="corner-right-top" data-pt-width='1200' data-pt-scheme="white"
                 data-pt-title="<pre class='protip-mine'>{{\Tools::ipInfo($comment['ip'])}}</pre>"
                 class="comment-img protip" src="/images/comp.png"
            > {{$comment['username']}}  {{ $comment['created_at']}}
            @if ($comment['ip'] == request()->ip() || \Tools::isAdmin())
              <a href="/comment/{{$comment['id']}}/delete"><img
                  style='position:relative;top:2px;width:10px;height: 10px;'
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
        <textarea name="comment" class="text-comment" required
                  placeholder="inject en code / text">{{$precomment ?? ''}}</textarea>
        <br/>
        <button class="commit-button">push comment</button>
      </form>
    </div>
    <div class="bottom-line page-info">
      <span class="page-info-item"><strong>√</strong>iews: {{$views}}</span>
      <span class="page-info-item"> Edits: {{$edits}}</span>
      <span class="page-info-item">Updated: {{$page['updated_at']}}</span>
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
          <a class="alignnmiddle" href="/touch/{{$code}}">touch</a>
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
  <div id="fb-root"></div>
@endsection

@push('scripts')
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

  <script>window.twttr = ( function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
      if( d.getElementById(id) ) return t;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://platform.twitter.com/widgets.js";
      fjs.parentNode.insertBefore(js, fjs);

      t._e = [];
      t.ready = function(f) {
        t._e.push(f);
      };

      return t;
    }(document, "script", "twitter-wjs") );</script>

  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v9.0"
          nonce="YLGawk8W"></script>
@endpush
