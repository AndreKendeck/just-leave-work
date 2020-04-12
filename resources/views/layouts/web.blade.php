<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title') - JustLeave Work </title>
     <meta name="description" content="Web-based leave management application" />

     <link rel="apple-touch-icon" sizes="57x57" href="{{  asset('images/apple-icon-57x57.png') }}">
     <link rel="apple-touch-icon" sizes="60x60" href="{{  asset('images/apple-icon-60x60.png') }}">
     <link rel="apple-touch-icon" sizes="72x72" href="{{  asset('images/apple-icon-72x72.png') }}">
     <link rel="apple-touch-icon" sizes="76x76" href="{{  asset('images/apple-icon-76x76.png') }}">
     <link rel="apple-touch-icon" sizes="114x114" href="{{  asset('images/apple-icon-114x114.png') }}">
     <link rel="apple-touch-icon" sizes="120x120" href="{{  asset('images/apple-icon-120x120.png') }}">
     <link rel="apple-touch-icon" sizes="144x144" href="{{  asset('images/apple-icon-144x144.png') }}">
     <link rel="apple-touch-icon" sizes="152x152" href="{{  asset('images/apple-icon-152x152.png') }}">
     <link rel="apple-touch-icon" sizes="180x180" href="{{  asset('images/apple-icon-180x180.png') }}">
     <link rel="icon" type="image/png" sizes="192x192" href="{{  asset('images/android-icon-192x192.png') }}">
     <link rel="icon" type="image/png" sizes="32x32" href="{{  asset('images/favicon-32x32.png') }}">
     <link rel="icon" type="image/png" sizes="96x96" href="{{  asset('images/favicon-96x96.png') }}">
     <link rel="icon" type="image/png" sizes="16x16" href="{{  asset('images/favicon-16x16.png') }}">
     <link rel="manifest" href="{{  asset('images/manifest.json') }}">
     <meta name="msapplication-TileColor" content="#ffffff">
     <meta name="msapplication-TileImage" content="{{  asset('images/ms-icon-144x144.png') }}">
     <meta name="theme-color" content="#ffffff">

     <meta property="og:type" content="website">
     <meta property="og:url" content="https://www.justleave.work/">
     <meta property="og:title" content="JustLeave | Leave Management ">
     <meta property="og:description" content="Web-based leave management application">
     <meta property="og:image" content="{{ asset('images/man.png') }}">

     <meta property="twitter:card" content="summary_large_image">
     <meta property="twitter:url" content="https://www.justleave.work/">
     <meta property="twitter:title" content="JustLeave | Leave Management ">
     <meta property="twitter:description" content="Web-based leave management application">
     <meta property="og:image" content="{{ asset('images/man.png') }}">

     <link rel="manifest" href="{{ asset('meta/manifest.json') }}">

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <link href="https://fonts.googleapis.com/css?family=Oxygen&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link rel="stylesheet" href="{{ asset('css/menu.css?v=4') }}">
     <script src="{{ asset('js/alpine.js') }}"></script>
</head>

<body style="font-family: 'Oxygen'" class="bg-gray-100">

     @component('components.alert')
     @endcomponent
     @component('components.menu')
     @endcomponent
     @component('components.nav')
     @endcomponent
    @yield('content')

     <script src="{{ asset('js/app.js') }}"></script>
     @yield('script')
</body>

</html>
