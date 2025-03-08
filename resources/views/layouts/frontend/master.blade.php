<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.frontend._head')

</head>
<body>

<a id="cartBtn" href="{{ route('cart') }}" class="text-center">
    <img src="{{ asset('frontend/img/cart_img.png') }}" style="max-width: 30px;" alt="cart">
    <br>
    <span style="font-size: 12px;">
        <span class="cart-count">
        <span class="count">{{ session('cart')!= null ?count(session('cart')):0 }}</span>
        </span> Items
    </span>
</a>

<button onclick="topFunction()" id="myBtn"><i class="icofont-hand-drawn-up"></i></button>
<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>

<div class="humberger__menu__wrapper">
    @include('layouts.frontend._mobileMenu')
</div>
<!-- Humberger End -->
<!-- Header Section Begin -->
<header class="header">
    @include('layouts.frontend._header')

</header>
<!-- Header Section End -->

@yield('content')

<!-- Footer Section Begin -->
    @include('layouts.frontend._footer')
<!-- Footer Section End -->

@include('layouts.frontend._scripts')

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
    let institute = "{{ route('search.autocomplete') }}";
    $('input#search').typeahead({
        source:  function (query, process) {
            return $.get(institute, { term: query }, function (data) {
                return process(data);
            });
        }
    });
</script>
</body>
</html>
