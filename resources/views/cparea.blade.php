@extends('layouts.app')

@section('content')
    <a href="/"><-index</a><br/>
    @for ($i = 0; $i < \App\XRandom::get(3000,7129); $i++)
        @if (\App\XRandom::scaled(0,6) > 2)
            <a href="/sync/{{\App\XRandom::get(1120,3129)}}"> <img
                    style="transform: rotate({{\App\XRandom::scaled(-360,360)}}deg);max-width:{{\App\XRandom::scaled(9,288)}}px;max-height: {{\App\XRandom::scaled(9,288)}}px"
                    src="cparea.rng?widthmax=32&heightmax=32&rnd={{\App\XRandom::get(1,55555)}}"
                    title="dark members cp area #{{\App\XRandom::scaled(-1360,1360)}}"></a>
        @endif
    @endfor

    <div>
        <a style='font-weight:20px;font-family: Impact' href="/media/in.png">SUPPORT THIS PROJECT (send comment with
            %SUM% to my bitcoin address, with SUM u would like to send to me for example send - 0 (or if youre using
            auction, send ru S services price for terrorizing me/per hour)
        </a>
    </div>

@endsection
