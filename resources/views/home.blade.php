@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="упячка, жопоебальня, лучи поноса и свежие патенты">текущая ситуация</h3>
      <div class="interesting-block-inner">
        @foreach ($news as $post)
          <span style="display:inline-table">
                            <a href="/view/{{$post['code']}}" data-pt-animate="bounceIn"
                               data-pt-title="<span class='protip-on-main'>{{ \App\Models\Tools::titleize($post['content']) }}</span>"
                               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                               title="Cost: ${{$post['cost'] ?? 0.0}}">{!! '' . $post['title'] !!}</a>
          </span>
        @endforeach
      </div>
    </div>
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="как дед прыгнул в коляску">интересные посты</h3>
      <div class="interesting-block-inner">
        @foreach ($interesting as $v)
          <span style="display:inline-table">
                            <a href="/view/{{$v['code']}}"
                               data-pt-animate="bounceIn"
                               data-pt-title="<span class='protip-on-main'>{{ \App\Models\Tools::titleize($v['content']) }}</span>"
                               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                               title="Cost: ${{$v['cost'] ?? 0.0}}">{!! '' . $v['header'] !!}</a>
            </span>
        @endforeach
      </div>
    </div>
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="заманчивые">заманчивые комментарии</h3>
      <div class="interesting-block-inner">
        @foreach ($comments as $c)
          @if ($c->page)
            <span style="display:inline-table">
                            <a href="/view/{{$c->page->code}}"
                               data-pt-animate="bounceIn"
                               data-pt-title="<span class='protip-on-main'>{{ substr(\App\Models\Tools::strip($c->page->content, true), 0, 128) . '...' }}</span>"
                               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                               title="Cost: ${{$c->page->cost ?? 0.0}}">{{ substr(\App\Models\Tools::strip($c->comment, true), 0, 32) . '...' }}</a>,
                        </span>
          @endif
        @endforeach
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      var audio = new Audio('/audio/Insert.mp3');
      audio.play();
    });
  </script>
@endpush
