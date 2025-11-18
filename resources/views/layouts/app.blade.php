<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg shadow-sm fixed-top py-1" style="background-color:#fbefe5;">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/image_480.png') }}" alt="Logo" width="50" class="me-2">
                    <span class="brand-text fw-bold fs-1 ms-2">Go Nippon!</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center gap-1">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color:#9F6B46;">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}" style="color:#9F6B46;">{{ __('Register') }}</a>
                                </li>
                        
                            @endif
                        @else
                                <li class="nav-item">
                                <a href="{{ route('post.create') }}" class="nav-link fs-2" style="color:#9F6B46;">
                                    <i class="fa-solid fa-circle-plus" ></i>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link fs-2" style="color:#9F6B46;">
                                    <i class="fa-regular fa-comment "></i>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('favorite') }}" class="nav-link fs-3" style="color:#9F6B46;">
                                    <i class="fa-regular fa-heart fa-lg"></i>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <button class="btn shadow-none nav-link d-flex align-items-center"
                                    id="account-dropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="color:#9F6B46;">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" 
                                            alt="{{ Auth::user()->name }}" 
                                            class="rounded-circle" 
                                            style="width: 40px; height: 40px; object-fit: cover;  flex-shrink: 0;">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary" 
                                        style="font-size: 40px;"></i>
                                    @endif
                                </button>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2"
                                    aria-labelledby="account-dropdown">
                                    {{-- @can('admin') --}}
                                        <a href="{{ route('admin.users') }}" class="dropdown-item"><i class="fa-solid fa-lock me-2"></i></i> Admin</a>
                                    {{-- @endcan --}}

                                    <hr class="dropdown-divider">
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item"><i class="fa-solid fa-user me-2"></i> Profile</a>

                                    <a href="#" class="dropdown-item"
                                        data-bs-toggle="modal"
                                        data-bs-target="#notificationModal"
                                        id="notificationBtn">
                                        <i class="fa-solid fa-toggle-on me-2"></i>Notification
                                    </a>

                                    <a href="{{ route('analytics.index', Auth::user()->id) }}" class="dropdown-item"><i class="fa-solid fa-chart-line me-2"></i>Analytics</a>

                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>  
            </div>
        </nav>

        <nav class="navbar fixed-top d-flex d-lg-none" style="background-color:#fbefe5;">
            <div class="container d-flex justify-content-between align-items-center">

                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/image_480.png') }}" alt="Logo" width="40" class="me-2">
                    <span class="brand-text fw-bold fs-3">Go Nippon!</span>
                </a>

                <button class="btn p-0 border-0 bg-transparent" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fa-solid fa-bars fa-2x"></i>
                </button>
            </div>
        </nav>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" style="border-left:2px solid #d1a07d;">
    
            <div class="offcanvas-header border-bottom" style="background-color:#fff5ee;">
                @if (Auth::check())
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="d-flex align-items-center text-decoration-none">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" 
                                alt="{{ Auth::user()->name }}" 
                                class="rounded-circle me-3" 
                                style="width:50px; height:50px; object-fit:cover;">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary me-3" 
                            style="font-size:50px;"></i>
                        @endif
                        <span class="fw-bold" style="color:#9F6B46; font-size:20px;">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
                        <i class="fa-solid fa-circle-user text-secondary me-3" style="font-size:50px;"></i>
                        <span class="fw-bold" style="color:#9F6B46; font-size:20px;">Login</span>
                    </a>
                @endif
            </div>

            <div class="offcanvas-body d-flex flex-column align-items-center justify-content-start text-center pt-4">
                <ul class="list-unstyled w-100">
                    <li class="mb-3">
                        <a href="{{ route('home') }}" class="menu-link nav-text-brown">
                            <i class="fa-solid fa-store me-3"></i> Home
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('post.create') }}" class="menu-link nav-text-brown">
                            <i class="fa-solid fa-circle-plus me-3"></i> Create Post
                        </a>
                    </li>
                    {{-- <li class="mb-3">
                        <a href="" class="notificationBtn menu-link nav-text-brown">
                            <i class="fa-regular fa-heart me-3"></i> Notifications
                        </a>
                    </li> --}}
                    <li class="mb-3">
                        <a href="#" class="notificationBtn menu-link nav-text-brown position-relative">
                            <i class="fa-regular fa-bell me-3"></i> Notifications

                            {{-- 未読通知がある場合に赤丸バッジ --}}
                            @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="" class="menu-link nav-text-brown">
                            <i class="fa-regular fa-comment me-3"></i> Messages
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="" class="menu-link nav-text-brown">
                            <i class="fa-regular fa-star me-3"></i> Favorite Post
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#" class="notificationBtn menu-link nav-text-brown">
                            <i class="fa-solid fa-toggle-on me-3"></i> Notification
                        </a>
                    </li>
                </ul>

                <div class="d-flex justify-content-around mt-3 w-100">
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn" style="border: 2px solid #F1BDB2; color: #F1BDB2; font-weight: bold; background-color: transparent; transition: 0.3s;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <a href="" class="btn" style="background-color:#F1BDB2; color:white; font-weight:bold; transition:0.3s;">
                        <i class="fa-solid fa-lock"></i> Admin
                    </a>
                </div>
            </div>
        </div>

        <main class="mt-4 py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')

    @stack('scripts')


    <!-- 通知モーダル -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Notifications 🔔</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="notificationList">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const notificationBtns = document.querySelectorAll(".notificationBtn, #notificationBtn");
        const notificationList = document.getElementById("notificationList");

        notificationBtns.forEach(btn => {
            btn.addEventListener("click", async () => {
                notificationList.innerHTML = "<p>Loading...</p>";

                try {
                    const res = await fetch("/notifications");
                    const notifications = await res.json();

                    if (!Array.isArray(notifications) || notifications.length === 0) {
                        notificationList.innerHTML = "<p>No notifications.</p>";
                        return;
                    }

                    let html = "";
                    notifications.forEach(n => {
                        html += `
                            <div class="d-flex align-items-center mb-3">
                                <img src="${n.image || 'https://via.placeholder.com/50'}"
                                    alt="${n.user}" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <strong>${n.user}</strong><br>
                                    <small>${n.action}</small><br>
                                    <span class="text-muted">${n.time}</span>
                                </div>
                            </div>
                        `;
                    });

                    notificationList.innerHTML = html;
                } catch (error) {
                    console.error(error);
                    notificationList.innerHTML = "<p>Error loading notifications.</p>";
                }
            });
        });
    });
    </script>

</body>
</html>
