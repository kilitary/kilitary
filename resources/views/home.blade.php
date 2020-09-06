@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>hello {{ $info }}</h2>
        @if (isset($gdiSelected) && $gdiSelected)
            <h3> global defense initiative selected (in {{ mt_rand(0,1) ? 'case' : 'state' }} of {{$chanceOf}})</h3>
        @else
            <h3> brotherhood of nod selected (in {{ mt_rand(0,1) ? 'case' : 'state' }} of {{$chanceOf}})</h3>
        @endif

        <div style="font-size:13px;font-variant: small-caps;font-family: consolas">sign {!! $sign !!}</div>
        <div class="links"><a href='/command/sync?{{request()->path()}}'>sync</a></div>

        <div class="shortener">
            <form method="post" action="/su/create">
                {{ csrf_field() }}
                <div><label for="short"> short</label><input name="short" placeholder="{{$shortUrl->short}}"></div>
                <div><label for="long"> long</label> <input name="long" placeholder="{{$shortUrl->long}}"></div>
                <div>
                    <button>add short/long translation</button>
                </div>
            </form>
        </div>

        <div>
            coming soon: free magick email @ kiltary.ru | ?
        </div>
    </div>
@endsection
