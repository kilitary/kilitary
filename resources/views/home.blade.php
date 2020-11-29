@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>hello {{ $info }} (first neuro<span style="font-size:6px">-bio-ceramic-</span>cloud-based
            server, {{(\App\XRandom::scaled(0,1) ? 'p' : 'o')}}wned by <a
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
            <div class="marginleft marginbottom interesting-block">
                <h3 class="section-h3 interesting-item">information on adjacent orders area</h3>
                <div class="interesting-block-inner">
                    @foreach ($interesting as $v)
                        <span style="display:inline-table">
                            <a href="/view/{{$v['code']}}"
                               data-pt-animate="bounceIn"
                               data-pt-title="<span class='protip-on-main'>{{ \App\Models\Tools::titleize($v['content']) }}</span>"
                               class="protip interestlink" data-pt-gravity="top-left" data-pt-scheme="white"
                               title="Cost: ${{$v['cost'] ?? 0.0}}">{!! '' . $v['header'] !!}</a>,

                        </span>
                    @endforeach
                    <a href="/relink">..</a>
                </div>
            </div>

            <div class="marginleft marginbottom interesting-block">
                <h3 class="section-h3 interesting-item">information on comments area</h3>
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
            <div class="marginleft smallcaps">
                create new info here: <a href="/page/new">+create</a>
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
                @if(\App\XRandom::get(0,6) == 4)
                    global defense initiative selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }}
                    of {{$chanceOf}}
                    )

                @else
                    brotherhood of nod selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }} of {{$chanceOf}}
                    )
                @endif
            </div>

            ( <a href="/cpu.txt" class="cpu-item"><img src="/images/USB.png">cpuID</a>) 202x-204x @ <a
                href="mailto:kilitary@protonmail.com">kil</a><a
                href="mailto:kilitary@x25.cc">it</a><a href="mailto:deconf@kilitary.ru">ary</a><a
                href="mailto:deconf@ya.ru">.ru</a>
            | {{request()->ip()}}? <a href="/gays" title="Gay Emission Toolkit Array (GETA)">
                | {{ isset($gaysCount) ? $gaysCount . " gay(s) in db" : "" }}</a>
            | {!! \App\Models\Tools::isProbablyGay() ? '<span color=red class="blinking-red">probably boss gay detected</span>':""!!}
            <span>
                <img class="new-stamp" title="check it out [new function]" src="/images/new2.png" width="32px"
                     height="32px">
                [<a class="destroy-link" title="you have 10 reel destroys left" href="/destroy">destroy site</a>]
            </span>
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
