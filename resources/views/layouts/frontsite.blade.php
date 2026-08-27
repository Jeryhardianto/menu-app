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
            /* samakan dengan .content-wrapper supaya area footer tidak jadi pita putih */
            background-color: #f4f6f9;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
    @include('sweetalert::alert')

    @include('components.frontsite.header')
        @yield('content')
    @include('components.frontsite.footer')
    @include('components.frontsite.bottom-nav')

    @stack('before-script')
        @include('includes.backsite.script')
    @stack('after-script')
</body>
</html>
