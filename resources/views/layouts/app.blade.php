<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>{{ config('app.name') }} @yield('title')</title>

    @include('partials.meta-tags')

    <!-- favicon -->
    @include('partials.favicon')

    <!-- Critical Stylesheets -->
    <style>{{ include public_path('build/assets/home_critical.min.css') }}</style>

    <!-- Styles -->
    <link href="<?php echo mix('assets/vendor/bootstrap.css'); ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo mix('assets/vendor/bootstrap.css'); ?>" media="print" onload="this.media='all'"
    <noscript><link rel="stylesheet" href="<?php echo mix('assets/vendor/bootstrap.css'); ?>"></noscript>

    <link href="<?php echo mix('assets/vendor/fonts.css'); ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo mix('assets/vendor/fonts.css'); ?>" media="print" onload="this.media='all'"
    <noscript><link rel="stylesheet" href="<?php echo mix('assets/vendor/fonts.css'); ?>"></noscript>

    <link href="<?php echo mix('assets/app.css'); ?>" rel="preload" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="<?php echo mix('assets/app.css'); ?>" media="print" onload="this.media='all'"
    <noscript><link rel="stylesheet" href="<?php echo mix('assets/app.css'); ?>"></noscript>

    @yield('extra-css')
</head>
<body>
    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ mix('assets/vendor/bootstrap.js') }}"></script>
    <script src="{{ mix('assets/app.js') }}"></script>
    <script src="{{ mix('assets/custom.js') }}"></script>

    @yield('extra-script')
</body>
</html>
