<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title') - Visit Ajk</title>
        <link rel="icon" href="{{ asset('/assets/img/public/logo.png') }}" type="image/png">
        @include('include.head')
        @yield('style')
    </head>
    <body class="nav-fixed">
        @include('include.navbar')
        <div id="layoutSidenav">
            @include('include.sidebar')
            <div id="layoutSidenav_content">
                @yield('content')
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright © 2025 AJ&K Information Technology Board</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">All Rights Reserved.</a>
                                ·
                                <a href="#!">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @include('include.footer')
        @stack('scripts')
</body>
</html>
