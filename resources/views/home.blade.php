@extends('layouts.app')

@section('content')
    <div class="container">

        <h2>hello {{ $info }} ({{(\App\XRandom::scaled(0,1) ? 'p' : 'o')}}wned by <a
                target=_blank href='https://twitter.com/{{$pwnedBy}}'>{{$pwnedBy}})</a></h2>
        <div class="marginleft">
            @if (isset($gdiSelected) && $gdiSelected)
                <h3> global defense initiative selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }}
                    of {{$chanceOf}}
                    )</h3>
            @else
                <h3> brotherhood of nod selected (in {{ \App\XRandom::scaled(0,1) ? 'case' : 'state' }} of {{$chanceOf}}
                    )</h3>
            @endif


            @if (empty($sign))
                <span color=red class="blinking-red"><< empty >></span>
            @else
                <div style="font-size:13px;font-variant: small-caps;font-family: consolas">sign {!! $sign !!}</div>
            @endif
            <div class="links"><a href='/command/sync?{{request()->path()}}'>sync?</a></div>
        </div>

        <div class="shortener">
            <form method="post" action="/us/create">
                {{ csrf_field() }}
                <div><label for="short"> short</label><input name="short" placeholder="{{$shortUrl->short}}"></div>
                <div><label for="long"> long</label> <input name="long" placeholder="{{$shortUrl->long}}"></div>
                <div>
                    <button>add short/long url translation (url shortener) or just click this button</button>
                </div>
            </form>
        </div>

        <div class="marginleft">
            {!! nl2br(`/usr/bin/timedatectl`) !!}<br/>
            {{ $fortune }}
        </div>

        <div>
            coming soon: free magick email (life pro-longer) @ kilitary.ru | ?
        </div>
    </div>
@endsection
