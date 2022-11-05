@extends('layouts.app')



@section('content')
  <div class="container">
    <div class="marginleft marginbottom interesting-block">
      <h3 class="section-h3 interesting-item"><img class='img-t' src='/images/trigger2.png'> <a title='add' href='/comment/add'>+</a></h3>
      <div class="interesting-block-inner">

        @foreach ($comments as $c)

          <div class='interesting-block-row'>
            <a class="comment-href protip interestlink" href="/comment/{{$c['id']}}/view/"
               data-pt-animate="bounceIn"
               data-pt-title="<div class='protip-on-main'><span>{{$c['username']}} @ {{$c->created_at_diff}}:</span>
               <div class='comment-tooltip'>{{$c['comment']}}</div>
               </div>"
               data-pt-gravity="top-left"
               data-pt-scheme="white"
               title="bytes in: {{$c['cost'] ?? 0.0}}">
              {{ \Str::limit(\Tools::strip($c['prefix'], true), 256, '...') }}
            </a>
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
               class="protip interestlink news-href"
               title="Фулл: {{ sprintf("%.2fMB", $post->length / 1024.0 / 1024.0) }}">
              {!! \Tools::titleize($post['title'], 2128) !!}
            </a>

            <div class='post-tools'>
              <div class='data-row'>
                <a href='/rate/{{$post->id}}'
                   data-pt-classes='protip-sh-main'
                   data-pt-gravity='bottom-right 100 15'
                   data-pt-skin='white'
                   class="protip  tool-link"
                   data-pt-title='<span class="tool-button">code convergence (<span class=green>{{$post->prog_ok}}</span> vs <span class="red">{{$post->prog_bad}}</span>)</span>'>
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
      <h3 class="section-h3 interesting-item" title="из сетевой карты"><img class='img-t' src='/images/group_small.png'></h3>
      <div class="interesting-block-inner">

        @foreach ($videos as $v)

          <div class='interesting-block-row'>
            <a class='video-header-link' data-pt-width='800'
               data-pt-gravity='top-left 30 -20'
               data-pt-classes='protip-sh-main'
               data-pt-skin='white'
               data-pt-arrow='true'
               data-pt-title="<span class='protip-on-main'>
                views {{$v->views}} len {{$v->length}}
               </span>">
              {{$v->description}}
            </a>
            <div class="video-row">
              {!! $v->html !!}
            </div>
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

@section('classes', 'main')
