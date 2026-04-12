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
                            <a target="_blank" href="{{ $link->pinterest }}"><i class="fa fa-instagram"></i></a>
                        @endisset
                        @isset($link->linkedin)
                            <a target="_blank" href="{{ $link->linkedin }}"><i class="fa fa-linkedin"></i></a>
                        @endisset
                        |
                    </div>

                        @if(Auth::user())
                            <div class="header__top__right__auth mr-3">
                                <a href="{{ route('user.dashboard') }}"><i class="icofont-boy"></i> {{ ucfirst(auth()->user()->name) }}</a>
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
            <div class="col-lg-3 col-md-2 col-3 dv-none">
                <div class="p-3" style="cursor: pointer; padding-right: 0;">
                    <a style="color: #1c1c1c; font-size: 22px" href="#" data-toggle="modal" data-target="#searchModal">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-2 col-6">
                <div class="header__logo">
                    <a href="{{ route('home') }}">
                        <img id="header__logo" src="{{ asset((isset($link) && $link->logo != null)? $link->logo : 'uploads/default_logo.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="{{ Request::is('register') || Request::is('login')?'nav_hide':'' }} mv-none col-lg-7 col-xs-9 col-6">
                <div class="hero__search__form">
                    <form action="{{ route('product.find') }}" method="get" autocomplete="off">
                        <input required type="text" id="search" name="product" value="{{ request()->input('product') }}" style="color: black" placeholder="Search">
                        <button type="submit" class="site-btn">SEARCH</button>
                    </form>
                </div>
            </div>
            <div class="{{ Request::is('register') || Request::is('login')?'nav_hide':'' }} mv-none col-lg-2 col-xs-3 col-3" id="favncart">
                <div class="header__cart ">
                    <ul>
                        <li><a href="{{ route('favourite') }}" class="text-secondary"> <i class="fa fa-heart"></i> <span>{{ (isset($favourite))? $favourite : 0 }}</span></a> <sub>Favourite</sub> </li>
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
                    <li class="{{ Request::is('sale*')?'active':'' }}"><a href="{{ route('product.sale') }}">On Sale</a></li>
                    <li class="{{ Request::is('products/*')?'active':'' }}"><a href="#">Categories <i class="fa fa-angle-down"></i></a>
                        <ul class="header__menu__dropdown">
                            @foreach($categories as $category)
                                <li><a style="text-transform: capitalize" href="{{ route('product.category',$category->slug) }}">{{ ucfirst($category->name) }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="{{ Request::is('brands*')?'active':'' }}"><a href="#">Brands <i class="fa fa-angle-down"></i></a>
                        <ul class="header__menu__dropdown">
                            @foreach($brands as $brand)
                                <li><a style="text-transform: capitalize" href="{{ route('product.brand',$brand->slug) }}">{{ $brand->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="{{ Request::is('contact-us')?'active':'' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="{{ Request::is('blog*')?'active':'' }}"><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="{{ Request::is('announcement')?'active':'' }}"><a href="{{ route('offer') }}">Announcements !</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal" id="searchModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="hero__search__form">
                    <form action="{{ route('product.find') }}" method="get" autocomplete="off">
                        <input required type="text" id="search" name="product" value="" style="color: black" placeholder="Search here">
                        <button type="submit" class="site-btn">SEARCH</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                &nbsp;
            </div>

        </div>
    </div>
</div>
