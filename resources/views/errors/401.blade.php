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
</head>

<body>
    <div class="container text-center">
        <img src="{{ asset('img/unauthorized.svg') }}" alt="Unauthorized Access Illustration" class="img-fluid my-4">
        <h1 class="display-4">Akses Gagal</h1>
        <p class="lead mb-4">Saat Ini Anda Tidak Memiliki Akses Untuk Menggunakan Aplikasi.</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">Back to Login</a>
    </div>
</body>

</html>
