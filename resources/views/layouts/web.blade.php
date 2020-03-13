<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title') - JustLeave Work </title>
     <meta name="description" content="Web-based leave management application" />

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
     @component('components.head')
     @endcomponent
     <div class="h-screen mb-5">
          @yield('content')
     </div>
     @component('components.tabs')
     @endcomponent
     <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>