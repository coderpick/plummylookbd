<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.frontend._head')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5QZHG53"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <a id="cartBtn" href="{{ route('cart') }}" class="text-center">
        <i class="fa fa-shopping-cart" style="font-size: 20px;"></i> <br>
        <span style="font-size: 12px;">
            <span class="cart-count">
                <span class="count">{{ session('cart') != null ? count(session('cart')) : 0 }}</span>
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
    <div id="mobileBottomNav">
        <nav class="mobile-bottom-nav">
            <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fa fa-home"></i>
                        Home
                    </div>
                </a>
            </div>
            <div class="mobile-bottom-nav__item mobile-bottom-nav__item--active">
                <a href="{{ route('front.category') }}" class="text-decoration-none">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fa fa-th-list"></i>
                        Categories
                    </div>
                </a>
            </div>
            <div class="mobile-bottom-nav__item">
                <a href="{{ route('user.dashboard') }}" class="text-decoration-none">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fa fa-user"></i>
                        Account
                    </div>
                </a>
            </div>

            <div class="mobile-bottom-nav__item">
                <a href="{{ route('cart') }}" class="text-decoration-none">
                    <div class="mobile-bottom-nav__item-content">
                        <i class="fa fa-shopping-bag"></i>
                        <span>
                            <span class="cart-count">
                                <span class="count">{{ session('cart') != null ? count(session('cart')) : 0 }}</span>
                            </span>
                            Items
                        </span>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    @include('layouts.frontend._scripts')

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}")
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}")
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}")
        @endif

        let routeUrl = "{{ route('product.details', 'placeholder_id') }}";
        let institute = "{{ route('search.autocomplete') }}";
        $('input#search').typeahead({
            source: function(query, process) {
                return $.get(institute, {
                    term: query
                }, function(data) {
                    return process(data);
                });
            },
            items: 30,
            // 2. Tell Typeahead to show the 'name' in the list
            displayText: function(item) {
                return item.name;
            },
            // 3. Use 'updater' to handle the click event
            updater: function(item) {
                // Replace the dummy text in the URL with the actual item slug
                let finalUrl = routeUrl.replace('placeholder_id', item.slug);

                // Redirect the user to the new URL
                window.location.href = finalUrl;

                // Return the name to keep the input box filled (optional)
                return item.name;
            }
        });
    </script>
</body>

</html>
