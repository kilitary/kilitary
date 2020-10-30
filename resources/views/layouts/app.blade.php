<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xml:lang="王宇ー！のドッ" manifest="/cache.manifest">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="{{$description ?? $keys ?? 'v2k, military, fss, fbi, cia, nsa, nasa, intrepol, thales of the futur e'}}">
    <meta name="generator" content="laraGEN">
    <meta name="document-state" content="dynamic">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="0c0bf1373a8046f1"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>

    <link rel="icon" type="image/png" href="/images/lock.png">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {(m[i].a = m[i].a || []).push(arguments);};
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a);
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(68175511, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true,
            trackHash: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/68175511" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') . '?id='.hash('md5',\App\XRandom::get(1,99999999))}}"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179562632-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {dataLayer.push(arguments);}

        gtag('js', new Date());
        gtag('config', 'UA-179562632-1');
    </script>

    <script src="https://randojs.com/2.0.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/protip@1.4.21/protip.min.js"></script>

    <link href="https://fonts.cdnfonts.com/css/liberation-mono" rel="stylesheet">
    <link href="{{ asset('css/app.css') . '?id='.hash('md5',\App\XRandom::get(1,99999999))}}" rel="stylesheet">
    <link rel="stylesheet" href="//min.gitcdn.xyz/repo/wintercounter/Protip/master/protip.min.css">
</head>
<body>
<header>
    @if (Route::currentRouteName()=='home')
        <div id="flagleft"></div>
    @endif
    <div id="flagright"></div>

    <div style="float:right;position: absolute;top: 10px;left: 100px">
        <a target=_blank href="/images/operatoR.jpg">
            <img class="crysa-class" title="Crysa class server admin (Moulder ¾ 7+)" src="/images/krisa.png"></a>
    </div>
</header>

<div id="app">
    <article role="main">
        <main class="@yield('classes')">
            @yield('content')
        </main>
    </article>
</div>

<footer>
    <br/><img src="/images/flatten.png"> Your cart is full<br/>
    <a href="/cparea"><img src="/images/constructionNotice.jpg" width="64" height="64" class="construct-logo"
                           title="SITE IS UNDER ACTIVE DEVELOPMENT: EXPECT BUGS/ERRORS/FATALITYS AND NO INCOME"></a>
    <div class="car">
        <img height='400px' src="/images/car{{(\App\XRandom::scaled(0,1)==1?'3':'')}}.jpg">
    </div>
    @if (\App\Models\Tools::IsAdmin())
        <ul>
            <li><a href="/admin/logs">logs</a></li>
            <li>
                <pre id="logs">--logs--</pre>

            </li>
        </ul>
    @endif

</footer>
@yield('scripts')
</body>
</html>

