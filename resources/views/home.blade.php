@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item"><a href='/news/reload'><img class='img-t' src='/images/LabVIEW_object.png'></a></h3>
      <div class="interesting-block-inner">
        @foreach ($news as $post)
          <div class='interesting-block-row'>
            <a href="/news/{{$post->slug}}"
               data-pt-width='800'
               data-pt-gravity='top-left 30 -20'
               data-pt-classes='protip-sh-main'
               data-pt-skin='white'
               data-pt-arrow='true'
               data-pt-title="<span class='protip-on-main'>
               {{Carbon::parse($post->published_at)->toDayDateTimeString()}}
               </span>
                <div class='block-preview'>
                 <div>{{ $post->category_name_old ?? 'y'}}</div>
                  <div>${{$post['cost'] ?? 0.0}}</div>
                  @if(strlen($post->description))
                    {{ $post->description }}
                  @endif
                  @if(strlen($post->image_url))
                    <img class='post-image' src='{{$post->image_url}}'>
                  @endif
                </div>"
               class="protip interestlink"
               title="Фулл: {{ sprintf("%.2fMB", $post->length / 1024.0 / 1024.0) }}">
              {!! \App\Models\Tools::titleize($post['title'], 2128) !!}
            </a>
            <div class='post-tools'>
              <div class='data-row'><a href='#' data-pt-classes='protip-sh-main' data-pt-gravity='bottom-right 100 15' data-pt-skin='white' class="protip  tool-link" data-pt-title='<span class="tool-button"></span>'>
                  <img class='data-row-ico' src='/images/icon-integration.png'><span>
                    @foreach($post->prog_codes as $code)
                      <a class='prog-code' href='/rate/{{$code}}'>{{$code}}</a>
                    @endforeach
                  </span> </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item" title="из сетевой карты"><img src='/images/usergroups.png'></h3>
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
      <h3 class="section-h3 interesting-item"><img src='/images/trigger2.png'></h3>
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
  <audio id="notification" src="/audio/Insert.mp3" muted></audio>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('body').trigger('click');
      document.getElementById('notification').muted = false;
      document.getElementById('notification').play();

    });
  </script>
@endpush
