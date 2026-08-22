<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CityCare Medical Centre') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body.auth-body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .auth-bg {
            position: fixed;
            inset: 0;
            background-image: url('{{ asset('images/auth-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(6px) brightness(0.6);
            transform: scale(1.1);
            z-index: -2;
        }
        .auth-overlay {
            position: fixed;
            inset: 0;
            background: rgba(52, 50, 74, 0.45);
            z-index: -1;
        }
    </style>
</head>
<body class="auth-body">
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>

    <div class="w-100" style="max-width: 420px;">
        <div class="text-center mb-3">
            <a href="{{ url('/') }}" class="text-decoration-none d-inline-flex align-items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="CityCare Logo" style="height:40px;" onerror="this.style.display='none'">
                <span class="fw-bold fs-4 text-white">CityCare Clinic</span>
            </a>
        </div>
        <div class="card shadow" style="border-top: 4px solid #d8b4e2;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>