<!DOCTYPE html>
<html lang="en">

{{-- Designed And Developed By Ahsan Danish --}}

<head>
    <meta name="keywords" content="AJK, Youth Loan, PMYP, Small Industries" />
    <meta property="og:title" content="@yield('title') - PMYP">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:description" content="Prime Minister Youth Loan Program for AJK Small Industries">

    <title>@yield('title') - PMYP</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @include('include.head-public')
    @yield('style')
</head>

<body>
    @include('include.topstrip-public')
    @include('include.navbar-public')
    @yield('content')
    @include('include.footer-public')
    @include('include.foot-public')
    @stack('scripts')
</body>

</html>
