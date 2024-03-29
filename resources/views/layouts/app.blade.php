<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(env('APP_LOGO')) }}" type="image/x-icon">

    <!-- FontAwesome core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
</head>

<body>
    <!-- header -->
    <header class="py-md-2 bg-white py-1">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="d-flex gap-md-3 align-items-center gap-2">
                <img src="{{ asset(env('APP_LOGO')) }}" class="" width="50">
                <h1 class="fw-bold text-primary m-0">
                    {{ env('APP_NAME') }}
                </h1>
            </div>
            <div class="d-flex gap-md-3 align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#notifikasiModal">
                    <i class="fa-solid fa-bell"></i>
                </button>
                <h5><span class="badge bg-light text-primary px-3 py-2 shadow-sm">Version. 2.3</span></h5>
            </div>

        </div>
    </header>

    {{-- Navigasi --}}
    <nav class="navbar navbar-expand-md navbar-light bg-white pt-3 shadow-sm">
        <div class="container-fluid">
            <button class="navbar-toggler w-100" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @php
                        if (Auth::user()->level == 'admin') {
                            $dashboard = 'admin';
                        }
                        if (Auth::user()->level == 'owner') {
                            $dashboard = 'owner';
                        }
                        if (Auth::user()->level == 'keuangan') {
                            $dashboard = 'keuangan';
                        }
                    @endphp
                    <li class="nav-item me-2">
                        <a class="nav-link {{ $activeMenu == 'dashboard' ? 'bg-warning text-white rounded' : '' }}"
                            href="{{ url('admin/dashboard-' . $dashboard) }}">
                            <i class="fa-solid fa-gauge"></i>
                            <span class="ms-1">Dashboard</span>
                        </a>
                    </li>

                    @if (in_array(Auth::user()->level, ['owner', 'keuangan']))
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'kategori' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/kategori') }}">
                                <i class="fa-solid fa-table-cells-large"></i>
                                <span class="ms-1">Kategori</span>
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'marketplace' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/marketplace') }}">
                                <i class="fa-solid fa-store"></i>
                                <span class="ms-1">Marketplace</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item me-2">
                        <a class="nav-link {{ $activeMenu == 'produk' ? 'bg-warning text-white rounded' : '' }}"
                            href="{{ url('admin/produk') }}">
                            <i class="fa-solid fa-box-open"></i>
                            <span class="ms-1">Produk</span>
                        </a>
                    </li>
                    @if (Auth::user()->level == 'owner')
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'user' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/user') }}">
                                <i class="fa-solid fa-users"></i>
                                <span class="ms-1">User</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item me-2">
                        <a class="nav-link {{ $activeMenu == 'penjualan' ? 'bg-warning text-white rounded' : '' }}"
                            href="{{ url('admin/penjualan') }}">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                            <span class="ms-1">Penjualan</span>
                        </a>
                    </li>
                    @if (Auth::user()->level == 'owner')
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'pembelian' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/pembelian') }}">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <span class="ms-1">Pembelian</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->level == 'owner')
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'pengeluaran' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/pengeluaran') }}">
                                <i class="fa-solid fa-credit-card"></i>
                                <span class="ms-1">Pengeluaran</span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->level == 'owner')
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $activeMenu == 'laporan' ? 'bg-warning text-white rounded' : '' }}"
                                href="{{ url('admin/laporan') }}">
                                <i class="fa-solid fa-file-lines"></i>
                                <span class="ms-1">Laporan</span>
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown"
                                class="nav-link dropdown-toggle {{ $activeMenu == 'profile' ? 'bg-warning text-white rounded' : '' }}"
                                href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" v-pre>
                                <i class="fa-solid fa-circle-user"></i>
                                <span class="ms-1">{{ Auth::user()->name }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('admin/profile') }}">
                                    <i class="fa-solid fa-user-gear"></i>
                                    <span class="ms-1">Profile</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    <span class="ms-1">{{ __('Logout') }}</span>
                                </a>

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

    {{-- Content --}}
    <main class="py-4">
        @yield('content')
    </main>

    <footer class="">
        <p class="text-muted mt-5 mb-3 text-center">
            Powered by <strong class="text-primary">{{ env('APP_COPYRIGHT') }}</strong> &copy; {{ date('Y') }}
        </p>
    </footer>

    {{-- Modal Notifikasi --}}
    <x-modal-less-stock />

    @include('sweetalert::alert')
    @yield('script')
</body>
</body>

</html>
