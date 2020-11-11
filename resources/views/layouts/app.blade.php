<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xml:lang="en" xml:x-lang="！王のッ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
          content="{{$description ?? $keys ?? 'v2k, military, fss, fbi, cia, nsa, nasa, intrepol, secret service, darpa, thales of the futur e'}}">
    <meta name="generator" content="laraGen">
    <meta name="document-state" content="dynamic">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="yandex-verification" content="0c0bf1373a8046f1"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="author" content="Sergey Efimov"/>

    <meta property="og:title" content="{{isset($page) ? $page->header : ($description ?? 'x25 vault')}}">
    <meta property="og:url" content="{{request()->fullUrl()}}">
    <meta property="og:site_name" content="kilitary thales of the future">
    <meta property="og:description" content="kilitary thales of the x25 future">
    <meta property="og:type" content="website">
    <meta property="og:image"
          content="/media/sh.png">

    <link rel="canonical" href="{{request()->fullUrl()}}"/>

    <link rel="icon" href="/images/lock.png" type="image/png">
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
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179562632-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {dataLayer.push(arguments);}

        gtag('js', new Date());
        gtag('config', 'UA-179562632-1');
    </script>
    <script src="/js/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="/js/2.0.0.js"></script>
    <script src="/js/protip.min.js"></script>
    <script src="{{ mix('js/app.js') . '?ver='.hash('crc32',\file_get_contents('js/app.js')) }}"></script>

    {{--<script src="https://www.googleoptimize.com/optimize.js?id=OPT-KCXWFW7"></script> --}}
    <link async href="/css/liberation-mono.css" rel="stylesheet">
    <link async rel="stylesheet"
          href="/css/protip.min.css">
    <link async rel="stylesheet" href="/css/animate.min.css"/>
    <link async href="{{ asset('css/app.css') . '?ver='.hash('crc32',\file_get_contents('css/app.css')) }}"
          rel="stylesheet">
</head>
<body>
<script type='application/ld+json'>
{
  "@context": "http://schema.org",
  "@type": "Article",
  "@id": "{{isset($page) ? $page->code : 'content'}}",
  "author": {
    "@type": "Person",
    "name": "deconf"
  },
  "dateModified": "{{\Carbon::now()->sub('1 hour')}}",
  "datePublished": "{{isset($page) ? $page->created_at : \Carbon::now()->sub('1 day')}}",
  "headline": "{{isset($page) ? $page->header : 'military'}}",
  "url": "{{request()->url()}}",
  "commentCount": {{$comments->count ?? 0}},
  "keywords": "php, laravel, military, illuminate",

"articleBody": "{{isset($page) ? $page->content : ''}}",
  "description": "{{isset($page) ? $page->description : ''}}",
  "publisher": {
    "@type": "Organization",
    "name": "axis9",
    "logo": {
      "@type": "ImageObject",
      "url": "/logo.png"
    },
    "url": "http://kilitary.ru"
  },
  "image": "/logo.png"
}






</script>
<header>
    @if (Route::currentRouteName()=='home')
        <div id="flagleft"></div>
    @endif
    <div id="flagright"></div>

    <div style="z-index:99999;float:right;position: absolute;top: 10px;left: 100px">
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
    <br/><img src="/images/flatten.png"> Your cart {{\App\Models\Tools::getCart() ? 'items: ':'is empty'}}
    @foreach (\App\Models\Tools::getCart() as $item)
        <span data-pt-scheme="white" class=" cart-item protip" data-pt-animate="bounceIn"
              data-pt-gravity="top-left"
              data-pt-title="<span class='protip-cart-item'>${{\App\Models\Tools::getItemCost($item)}}</span>">
            <a href="/view/{{$item}}">{{ $item }}</a>
        </span>
    @endforeach
    <div class="support-box">
        <a href="/donate" class="donate-link"><strong>i NEED</strong> support</a>
    </div>
    <a href="/cparea"><img src="/images/constructionNotice.jpg" width="64" height="64" class="construct-logo"
                           title="SITE IS UNDER ACTIVE DEVELOPMENT: EXPECT BUGS/ERRORS/FATALITYS AND NO INCOME"></a>

    <div class="car">
        <img height='400px' src="/images/car{{(\App\XRandom::scaled(0,2) == 1 ? '3' : '')}}.jpg">
    </div>

    @if (\App\Models\Tools::IsAdmin())
        <ul>
            <li><a href="/admin/logs">logs</a></li>
        </ul>
    @endif

</footer>
@yield('scripts')
</body>
</html>

