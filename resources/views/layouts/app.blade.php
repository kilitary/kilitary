<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xml:lang="en" xml:x-lang="！王 ↓ッ">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{$description ?? $keys ?? 'v2k, military, fss, secret service, darpa, thales of the futur e'}}">
  <meta name="generator" content="laragen">
  <meta name="generator-version" content="{{config('site.version')}}">
  <meta name="generator-author" content="Axis9 (an umbrella division)"/>
  <meta name="document-state" content="dynamic">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="author" content="CommandmentTwo"/>

  <meta property="og:title" content="{{isset($page) ? $page->header : ($description ?? 'x25 vault')}}">
  <meta property="og:url" content="{{request()->fullUrl()}}">
  <meta property="og:site_name" content="kilitary thales of the future">
  <meta property="og:description" content="kilitary thales of the x25 future">
  <meta property="og:type" content="website">
  <meta property="og:image" content="/media/sh.png">
  <meta property="og:description" content="Certification: ISO9001-> CE Height: Low Attitude Operating. Radius: 20km. Size: Small. Usage: Industrial Structure: Variable-Wing UAV.">

  <!--<meta property="fb:admins" content="292039974180201">
  <meta property="fb:page_id" content="10150525576765348">
  <meta property="fb:app_id" content="205885989426763">
  -->

  <link rel="canonical" href="{{request()->fullUrl()}}"/>
  <link rel="icon" href="/images/lock.png" type="image/png">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <title>{{ env('APP_NAME') }}</title>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179562632-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {dataLayer.push(arguments);}

    gtag('js', new Date());
    gtag('config', 'UA-179562632-1');
  </script>
  <script src="/js/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="/js/2.0.0.js"></script>
  <script src="/js/protip.min.js"></script>
  <script src="{{ mix('js/app.js') . '?ver='.hash('crc32',\file_get_contents('js/app.js')) }}"></script>
  <link async href="/css/liberation-mono.css" rel="stylesheet">
  <link href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css' rel='stylesheet'>
  <link async rel="stylesheet " href="/css/protip.min.css">
  <link rel="preconnect" href=""/>
  <link async rel="stylesheet" href="/css/animate.min.css"/>
  <link async href="{{ asset('css/app.css') . '?ver='.hash('crc32',\file_get_contents('css/app.css')) }}" rel="stylesheet">

  <link href='/css/fonts.css' rel='stylesheet'/>
</head>
<!--
# 2023
# (C) Umbrella Research Division Axis9.
# visit https://linktr.ee/kilitary?from=u for additional instructions
# contact commandment1349@gmail.com for contact, kilitary@gmail.com for spam, deconf@ya.ru for missinformation
-->
<!-- laragen @reltime :-->
<body>
<div class='bg'></div>
@inject('channelStatusProvider', '\App\Providers\ChannelStatusProvider')
<!--#{{ $channelStatusProvider->sign() }}#-->
<header class='cover-y'>
    <span class="header-text" title="последние манускрипты по защите от киберпреступников">
      Targeted Individuals In Russia <span style='color:{{$centerColor}}'>■</span> Local terror by russian psy operators<br/>
      <span class='header-lower-text'> Пситеррор в россии // нападение, защита и удаление</span>
    </span>
  <div class="bg-img">
  </div>
  <div style="z-index:99999;float:right;position: absolute;top: 10px;left: 100px">
    <a target=_blank href="/images/operatoR.jpg">
      <img class="crysa-class" title="Crysa class server admin " src="/images/krysa-class-server-admin.png"></a>
  </div>
</header>
<div id="app">
  @if(session('message'))
    <div class="alert alert-success">
      <div class="message">
        <span style="font-variant: all-petite-caps">system> {{session('message')}}</span>
      </div>
    </div>
  @endif
  <article role="main">
    <main class="@yield('classes')">
      @yield('content')
    </main>
  </article>
</div>
<footer class="bottom-line cover-y">
  ← <a class="destroy-link" title="you have 16 real destroys left" href="/destroy-page">cломать всё</a> ← <a href='/cparea'>админка</a> ←
</footer>
@stack('scripts')
<!--laragen-->
</body>
</html>
