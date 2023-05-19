<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Blog admin dashboard">
        
        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        {{ $css }}
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        @livewireStyles
    </head>
    <body>
        <div id="app">
            <nav id="navbar-main" class="navbar is-fixed-top">
                @include('parts.navbar')
            </nav>
            <aside class="aside is-placed-left is-expanded">
                @include('parts.menu')
            </aside>
            <section class="is-title-bar">
                {{ $title }}
            </section>
            <section class="is-hero-bar">
                {{ $hero }}
            </section>
            <section class="section main-section">
                {{ $slot }}
            </section>
            <footer class="footer">
                @include('parts.footer')
            </footer>
        </div>
        <script>var app_credentials = '<?= config('app.credensials.basic'); ?>';</script>
        {{ $scripts }}
        <script src="/js/main.js"></script>
        <script src="/js/app.js"></script>
        @livewireScripts
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    </body>
</html>
