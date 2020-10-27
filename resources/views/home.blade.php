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
            <div class="marginleft marginbottom">
                <h3 class="section-h3">inform/|tion on ADJACENT ORDERS AREA</h3>
                Interesting:
                @foreach ($interesting as $v)
                    <a href="/view/{{$v['code']}}" data-pt-title="{{ \App\Models\Tools::titleize($v['content']) }}"
                       class="protip interestlink"
                       title="{{trim($v['header'])}}">{!! '' . $v['header'] !!}</a>,
                @endforeach
                <a href="/relink">..</a>
            </div>
            <div class="marginleft smallcaps">
                create new info here: <a href="/page/{{$code}}">+create</a>
            </div>
        @endif

        <div class="marginleft">
            <h3 class="section-h3">time status</h3>
            {!! date(DATE_ATOM) !!}<br/>
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
            | {{request()->ip()}}? | {{ $gaysCount }} gay(s) in db
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
