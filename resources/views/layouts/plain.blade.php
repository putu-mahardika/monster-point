<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @yield('meta')
        <link rel="icon" href="{{ asset('img/logo_ps.png') }}">
        <title>@yield('title', 'title') | {{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
        @yield('css')
    </head>
    <body class="sb-nav-fixed" style="overflow-x: hidden;">

        @include('partials.topbar', [
            'settings' => [
                'sidebarToggle' => false,
                'help' => false,
                'notification' => false,
                'userAvatar' => false
            ]
        ])

        <main style="background-color: var(--ekky-light); min-height: calc(100vh - 4.6rem);">
            <div class="p-3">
                @yield('content')
            </div>
        </main>
        <footer class="py-3 mt-auto">
            <x-footer-text />
        </footer>

        @yield('modal')

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $(document).ready(() => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
        @yield('js')
    </body>
</html>
