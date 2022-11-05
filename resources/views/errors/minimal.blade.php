<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('code')</title>

  <!-- Fonts -->
  <link async href="{{ asset('css/app.css') . '?ver='.hash('crc32',\file_get_contents('css/app.css')) }}"
        rel="stylesheet">

</head>
<body>
<div class="flex-center position-ref full-height">

  <div class="message" style="padding: 10px;">
    @yield('message')
    <a href="/">return</a>
  </div>
</div>
</body>
</html>
