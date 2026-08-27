<!DOCTYPE html>
<html lang="en">
<head>

    @include('includes.backsite.meta')
    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
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

    @include('components.backsite.header')
    @include('components.backsite.menu')
        @yield('content')
    @include('components.backsite.footer')

    @stack('before-script')
        @include('includes.backsite.script')
    @stack('after-script')
</body>
</html>
