<div class="header__top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="header__top__left">
                    <ul>
                        <li><i class="icofont-ui-call"></i> Hotline: {{ $contact->phone??'' }} </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="header__top__right">

                    <div class="header__top__right__social mr-0">
                        @isset($link->facebook)
                            <a target="_blank" href="{{ $link->facebook }}"><i class="fa fa-facebook"></i></a>
                        @endisset
                        @isset($link->twitter)
                            <a target="_blank" href="{{ $link->twitter }}"><i class="fa fa-twitter"></i></a>
                        @endisset
                        @isset($link->pinterest)
                            <a target="_blank" href="{{ $link->pinterest }}"><i class="fa fa-pinterest"></i></a>
                        @endisset
                        @isset($link->linkedin)
                            <a target="_blank" href="{{ $link->linkedin }}"><i class="fa fa-linkedin"></i></a>
                        @endisset
                        |
                    </div>

                        @if(Auth::user())
                            <div class="header__top__right__auth mr-3">
                                <a href="{{ route('account') }}"><i class="icofont-boy"></i> {{ ucfirst(auth()->user()->name) }}</a>
                            </div>
                        @endif

                    @if(Auth::user())
                    <div class="header__top__right__auth">
                        <a class="text-left" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    @else
                        <div class="header__top__right__auth">
                            <a href="{{ route('login') }}"><i class="icofont-login"></i> Login / Register</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<div class="logo-section d-flex align-content-center flex-wrap" id="stickynav">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2 col-sm-12">
                <div class="header__logo">
                    <a href="https://emwbl.com/" target="_blank">
                        <img id="header__logo" src="{{ asset((isset($link) && $link->logo != null)? $link->logo : 'uploads/default_logo.png') }}" alt="Logo">
                        {{--<span>First Opportunity For All</span>--}}
                    </a>

                </div>
            </div>
            <div class="{{ Request::is('register') || Request::is('login')?'nav_hide':'' }} col-lg-7 col-xs-9 col-9">
                <div class="hero__search__form">
                    <form action="{{ route('product.find') }}" method="get" autocomplete="off">
                        <input required type="text" id="search" name="product" value="{{ request()->input('product') }}" style="color: black" placeholder="Search">
                        <button type="submit" class="site-btn">SEARCH</button>
                    </form>
                </div>
            </div>
            <div class="{{ Request::is('register') || Request::is('login')?'nav_hide':'' }} col-lg-2 col-xs-3 col-3" id="favncart">
                <div class="header__cart">
                    <ul>
                        <li id="m_cart"><a href="{{ route('cart') }}" class="text-secondary"> <i class="fa fa-shopping-cart cart-count"> <span class="count">{{ session('cart')!= null ?count(session('cart')):0 }}</span></i></a> <sub>Cart</sub> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <nav class="header__menu">
                <ul>
                    <li class="{{ Request::is('/')?'active':'' }}"><a href="{{ route('home') }}">Home</a></li>
                    <li class="{{ Request::is('shops')?'active':'' }}"><a href="{{ route('merchant.shop') }}">Shops</a></li>
                    <li class="{{ Request::is('sale*')?'active':'' }}"><a href="{{ route('product.sale') }}">On Sale</a></li>
                    <li class="{{ Request::is('contact-us')?'active':'' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="{{ Request::is('announcements')?'active':'' }}"><a href="{{ route('offer') }}">Announcements !</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
