@extends('layouts.app')

@section('content')
    @for ($i = 0; $i < \App\XRandom::scaled(1220,12290); $i++)
        <img style="transform: rotate({{\App\XRandom::scaled(-360,360)}}deg);max-width:64px;max-height: 64px"
             src="cparea.png?widthmax=32&heightmax=32&rnd={{\App\XRandom::get(1,55555)}}"
             title="dark microsoft members cp area">
    @endfor

    <div>
        <a style='font-weight:20px;font-family: Impact' href="/media/in.png">SUPPORT THIS PROJECT</a>
    </div>

@endsection
