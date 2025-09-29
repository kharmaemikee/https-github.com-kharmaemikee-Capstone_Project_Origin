<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Matnog Tourism') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('image/tourism.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('image/tourism.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="text-center mb-4">
        <a href="/">
            <x-application-logo class="w-50" />
        </a>
    </div>
    <div class="card shadow-sm w-100" style="max-width: 400px;">
        <div class="card-body">
            {{ $slot }}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
