<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="{{$description ?? 'v2k, military, fss, fbi, cia, nsa, nasa, intrepol, thales of the futur e'}}">
    <meta name="generator" content="laraGEN">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <div id="flagleft"></div>
    <div id="flagright"></div>
</header>
<div id="app">
    <main class="@yield('classes')">
        @yield('content')
    </main>
</div>

<footer>
    <div style="float:right;position: absolute;top: 10px;left: 100px">
        <a target=_blank href="/images/admin.jpg">
            <img class="crysa-class" title="crysa-class server admin" src="/images/krisa.png"></a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179562632-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {dataLayer.push(arguments);}

    gtag('js', new Date());

    gtag('config', 'UA-179562632-1');
</script>

@yield('scripts')
</body>
</html>

