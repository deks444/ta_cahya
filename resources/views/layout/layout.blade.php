<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/sf_logo.png') }}">
    <title>@yield('page-title', 'Sharefit')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    @include('layout.partials.navbar')
    @yield('content')
    @include('layout.partials.footer')
    @yield('script')
</body>

</html>