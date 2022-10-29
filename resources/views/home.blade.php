@php use App\XRandom;use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="в вашем мире (по версии секретных жопных войск)"'>текущая ситуация <a href='/news/reload' title='загрузить свежую ситуацию'><img src='/images/download.png'></a></h3>
      <div class="interesting-block-inner">
        @foreach ($news as $post)
          <div class='interesting-block-row'>
            <a href="/news/{{$post->slug}}" data-pt-animate="bounceIn"
               data-pt-width='800'
               data-pt-gravity='top-left 40 -40'
               data-pt-classes='protip-sh-main'
               data-pt-skin='white'
               data-pt-arrow='false'
               data-pt-title="<span class='protip-on-main'>
               {{Carbon::parse($post->published_at)->toDayDateTimeString()}} ■ {{ $post->category_name_old ?? 'Без темы'}} ■ Цена: {{$post['cost'] ?? 0.0}}$
               </span>
                <div class='block-preview'>
                  {{strlen($post->description) ? $post->description : '-'}}
                </div>"
               class="protip interestlink"
               title="Фулл: {{ sprintf("%.2fMB", $post->length / 1024.0 / 1024.0) }}">
              {!! \App\Models\Tools::titleize($post['title'], 2128) !!}
            </a>
            <div class='post-tools'>
              <a href='#' data-pt-classes='protip-sh-main' data-pt-gravity='bottom-right 100 15' data-pt-skin='white' class="protip  tool-link" data-pt-title='<span class="tool-button">опровергнуть</span>'><img
                  src='/images/child.png'> </a>
              <a href='#' data-pt-classes='protip-sh-main' data-pt-gravity='bottom-right 100 15' data-pt-skin='white' class="protip  tool-link" data-pt-title='<span class="tool-button">слинковать</span>'><img
                  src='/images/Wiring.png'> </a>
              <a href='#' data-pt-classes='protip-sh-main' data-pt-gravity='bottom-right 100 15' data-pt-skin='white' class="protip  tool-link" data-pt-title='<span class="tool-button">заказать</span>'><img
                  src='/images/xctl.png'> </a>

              <a href='#' data-pt-classes='protip-sh-main' data-pt-gravity='bottom-right 100 15' data-pt-skin='white' class="protip  tool-link" data-pt-title='<span class="tool-button">разьебать</span>'><img
                  src='/images/vendor.png'> </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="из сетевой карты" title='в вашем мире'>интересные посты</h3>
      <div class="interesting-block-inner">
        @foreach ($interesting as $v)
          <div class='interesting-block-row'>
            <a href="/view/{{$v['code']}}"
               data-pt-animate="bounceIn"
               data-pt-title="<span class='protip-on-main'>{{ \App\Models\Tools::titleize($v['content']) }}</span>"
               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
               title="{{$v->created_at}}@{{$v->category_name_old}} || Цена: ${{$v['cost'] ?? 0.0}}">{!! '' . $v['header'] !!}</a>
          </div>
        @endforeach
      </div>
    </div>
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title='в вашем мире'>заманчивые комментарии</h3>
      <div class="interesting-block-inner">
        @foreach ($comments as $c)
          @if ($c->page)
            <span style="display:inline-table">
                <a href="/view/{{$c->page->code}}"
                   data-pt-animate="bounceIn"
                   data-pt-title="<span class='protip-on-main'>{{ substr(\App\Models\Tools::strip($c->page->content, true), 0, 128) . '...' }}</span>"
                   class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                   title="Cost: ${{$c->page->cost ?? 0.0}}">{{ substr(\App\Models\Tools::strip($c->comment, true), 0, 32) . '...' }}</a>
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
