<!DOCTYPE html>
<html lang="en">
<head>

    @include('includes.backsite.meta')
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/png" sizes="16x16">
    @vite('resources/js/app.js')
    @stack('before-style')
      @include('includes.backsite.style')
    @stack('after-style')

    <style>
        body{
            font-family: quicksand;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('sweetalert::alert')

    @include('components.frontsite.header')
    @include('components.frontsite.menu')
        @yield('content')
    @include('components.frontsite.footer')

    @stack('before-script')
        @include('includes.backsite.script')
    @stack('after-script')
</body>
</html>
