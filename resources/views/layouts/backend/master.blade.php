<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.backend._head')
</head>
<body class="app sidebar-mini">
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="{{ route('home') }}" target="_blank"> {{ config('app.name') }} </a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    @include('layouts.backend._header')
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    @if (auth()->user()->type != 'vendor')
    @include('layouts.backend._aside')
    @else
    @include('layouts.backend._aside_vendor')
    @endif
</aside>
<main class="app-content">
    @yield('content')
</main>
<!-- Essential javascripts for application to work-->
@include('layouts.backend._scripts')

<!-- scripts for toastr to trigger-->
<script>
    @if(session('success'))
    toastr.success("{{ session('success') }}")
    @endif

    @if(session('error'))
    toastr.error("{{ session('error') }}")
    @endif

    @if(session('warning'))
    toastr.warning("{{ session('warning') }}")
    @endif
</script>

<script>
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
            e.preventDefault()
        })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll')
    })
</script>

</body>
</html>
