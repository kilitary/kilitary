@extends('layouts.app')

@section('content')
    @for ($i = 0; $i < \App\XRandom::get(12,12999992); $i++)
        <img
            style="transform: rotate({{\App\XRandom::scaled(-360,360)}}deg);max-width:{{\App\XRandom::scaled(99,188)}}px;max-height: {{\App\XRandom::scaled(99,188)}}px"
            src="cparea.png?widthmax=32&heightmax=32&rnd={{\App\XRandom::get(1,55555)}}"
            title="dark microsoft members cp area #{{\App\XRandom::scaled(1360,1360)}}">
    @endfor

    <div>
        <a style='font-weight:20px;font-family: Impact' href="/media/in.png">SUPPORT THIS PROJECT</a>
    </div>

@endsection
