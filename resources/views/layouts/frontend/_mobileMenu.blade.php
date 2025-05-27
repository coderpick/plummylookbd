<div class="humberger__menu__logo">
    <a href="{{ route('home') }}"><img style="max-height: 50px; max-width: 120px" src="{{ asset((isset($link) && $link->logo != null)? $link->logo : 'uploads/default_logo.png') }}" alt=""></a>
</div>

<div class="humberger__menu__widget">
    <div class="header__top__right__language">
        @if(Auth::user())
            <a style="color: var(--color-primary-dark) !important;" href="{{ route('account') }}"><i class="icofont-boy"></i> {{ ucfirst(auth()->user()->name) }}</a>
        @endif
    </div>
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
<nav class="humberger__menu__nav mobile-menu">
    <ul>
        <li class="active"><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#">Brands</a>
            <ul class="header__menu__dropdown">
                @foreach($brands as $brand)
                    <li><a href="{{ route('product.brand',$brand->slug) }}">{{ ucfirst($brand->name) }}</a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="#">Categories</a>
            <ul class="header__menu__dropdown">
                @foreach($categories as $category)
                    <li><a href="{{ route('product.category',$category->slug) }}">{{ ucfirst($category->name) }}</a></li>
                @endforeach
            </ul>
        </li>
        <li><a href="{{ route('contact') }}">Contact</a></li>
        <li><a href="{{ route('offer') }}">Announcements!</a></li>
    </ul>
</nav>
<div id="mobile-menu-wrap"></div>
<div class="header__top__right__social">
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
</div>
<div class="humberger__menu__contact">
    <ul>
        <li><i class="fa fa-envelope"></i>{{ (isset($contact) && $contact->email != null)? $contact->email : ' ' }}</li>
    </ul>
</div>
