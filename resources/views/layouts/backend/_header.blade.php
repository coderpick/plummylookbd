<ul class="app-nav">
    <li class="dropdown"><a class="app-nav__item" href="dashboard.html#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
            {{--<li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li>--}}
            <li><a class="dropdown-item" href="{{ route('user.info') }}"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            @if (auth()->user()->type == 'vendor')
            <li><a class="dropdown-item" href="{{ route('vendor.shop') }}"><i class="fa fa-archive fa-lg"></i> Store</a></li>
            @endif

            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i>Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
</ul>

