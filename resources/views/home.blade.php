@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>hello {{ $info }} ({{(\App\XRandom::scaled(0,1) ? 'p' : 'o')}}wned by <a
                target=_blank href='https://www.google.com/search?q={{$pwnedBy}}'>{{$pwnedBy}})</a>
        </h2>
        <div class="marginleft">

            <h3 class="section-h3" style="">am/spy link</h3>

            @if (empty($sign))
                target:  <span color=red class="blinking-red"><< unresolved >></span>
            @else
                <div style="font-size:13px;font-variant: small-caps;font-family: consolas">target {!! $sign !!}</div>
            @endif
            <div class="links"><a href='/command/sync?{{request()->path()}}'>synC</a></div>
        </div>


        @if (isset($shortUrl))
            <div class="shortener">
                <h3 class="section-h3">link shorterizer</h3>
                <form method="post" action="/us/create" autocomplete="off">
                    @csrf
                    <div style="padding-bottom:5px">
                        <label for="short" style="width:120px"> alphanumerical code
                            (may be blank)</label><br/><br/>
                        <input class="url-input" autocomplete="off" name="short"
                               placeholder="{{$shortUrl->short}}">
                    </div>
                    <div>
                        <label for="long" style="width:120px"> long uri (destination url)</label><br/><br/>
                        <input class="url-input" name="long" autocomplete="off" required
                               placeholder="{{$shortUrl->long}}">
                    </div>
                    <div>
                        <label for="long" style="width:120px"> </label><br/><br/>
                        <button class="wide-button">create link</button>
                    </div>
                </form>
            </div>
        @endif

        @if(isset($code))
            <div class="marginleft marginbottom ">
                <h3 class="section-h3">information on adjacent orders area</h3>
                <div class="interesting-block">
                    @foreach ($interesting as $v)
                        <span style="display:inline-table">
                            <a href="/view/{{$v['code']}}"
                               data-pt-animate="bounceIn"
                               data-pt-title="<span class='protip-on-main'>{{ \App\Models\Tools::titleize($v['content']) }}</span>"
                               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                               title="{{trim($v['header'])}}">{!! '' . $v['header'] !!}</a>,
                            </span>
                    @endforeach
                    <a href="/relink">..</a>
                </div>
            </div>
            <div class="marginleft smallcaps">
                create new info here: <a href="/page/{{$code}}">+create</a>
            </div>
        @endif

        <div class="marginleft">
            <h3 class="section-h3">tools area</h3>

            <a href="/proxy"
               data-pt-animate="bounceIn"
               data-pt-title="<span class='protip-on-main'>socks4/socks4a/socks5/http/https/smtp/web proxy/socks list</span>"
               class="protip interestlink" data-pt-scheme="white"
               title="free">proxy/socks list</a>
        </div>

        <div class="marginleft">
            <h3 class="section-h3">time status</h3>
            {!! date(DATE_ATOM) !!}<br/><br/>
            {{ $fortune }}
        </div>
        <div class="marginleft">
            <h3 class="section-h3">server status</h3>
            {{ `uptime` }}
        </div>


        <div class="topheadmargin">
            <div class="tib-war-header">
                @if (isset($gdiSelected) && $gdiSelected)
                    global defense initiative selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }}
                    of {{$chanceOf}}
                    )

                @else
                    brotherhood of nod selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }} of {{$chanceOf}}
                    )
                @endif
            </div>

            ( <a href="/cpu.txt"><img src="/images/USB.png">cpuID</a>) 202x-204x @ <a
                href="mailto:kilitary@protonmail.com">kil</a><a
                href="mailto:kilitary@x25.cc">it</a>ary<a
                href="mailto:deconf@ya.ru">.ru</a>
            | {{request()->ip()}}? | {{ isset($gaysCount) ? $gaysCount . " gay(s) in db" : "" }}
            | <a href="/donate" class="donate-link">i NEED support</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var audio = new Audio('/audio/Insert.mp3');
            audio.play();
        });
    </script>
@endsection
