@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item"><img class='img-t' src='/images/trigger2.png'> <a title='add' href='/comment/add'>+</a></h3>
      <div class="interesting-block-inner">
        @foreach ($comments as $c)
          <div class='interesting-block-row'>
            <a href="/comment/{{$c['id']}}/view/"
               data-pt-animate="bounceIn"
               data-pt-title="<span class='protip-on-main'>{{$c['username']}} @ {{$c->created_at}}</span>"
               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
               title="{{$c['comment']}} bytes in: {{$c['cost'] ?? 0.0}}">{{ \Str::limit(\App\Models\Tools::strip($c['prefix'], true), 256, '...') }}</a>
          </div>
        @endforeach
      </div>
    </div>

    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item"><a href='/news/reload' title='update'><img class='img-t' src='/images/LabVIEW_object.png'></a></h3>
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
              <div class='data-row'>
                <a href='/rate/{{$post->id}}'
                   data-pt-classes='protip-sh-main'
                   data-pt-gravity='bottom-right 100 15'
                   data-pt-skin='white'
                   class="protip  tool-link"
                   data-pt-title='<span class="tool-button">rate formation (<span class=green>{{$post->prog_ok}}</span> vs <span class=red>{{$post->prog_bad}}</span>)</span>'>
                  <img class='data-row-ico' src='/images/icon-integration.png'></a>
                @foreach($post->prog_codes as $code)
                  <a class='prog-code' style='color: {{$post->prog_color}};' @if($post->prog_last == $code) title='{{$post->prog_last_d}}' @endif>{{$code}}</a>
                @endforeach
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
