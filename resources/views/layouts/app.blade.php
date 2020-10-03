<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{$description ?? 'v2k, military, fss, fbi, cia, nsa, nasa, thales'}}">
    <meta name="generator" content="laragen">
    <title>{{ env('APP_NAME') }}</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179562632-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {dataLayer.push(arguments);}

        gtag('js', new Date());

        gtag('config', 'UA-179562632-1');
    </script>

</head>
<body>
<div id="app">

    <main class="@yield('classes')">
        @yield('content')
    </main>


</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

