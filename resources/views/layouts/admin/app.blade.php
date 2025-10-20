<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
     <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&family=Kosugi+Maru&family=Nunito:wght@400;600&display=swap" rel="stylesheet">


    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Font Awesome -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    {{-- Google Fontsの Source Serif Pro --}}
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@400;600&display=swap" rel="stylesheet">

    {{-- Leaflet  --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- D3.js --}}
    <script src="https://d3js.org/d3.v7.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>

<body>
  {{-- === ヘッダー === --}}
  <header>
    
  </header>

  {{-- === メインコンテンツ === --}}
  <main>
    @yield('content')
  </main>

  {{-- === フッター === --}}
  <footer>
  </footer>
</body>
</html>