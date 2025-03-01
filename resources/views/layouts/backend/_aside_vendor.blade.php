<div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="max-width: 48px; max-height: 48px;" src="{{ asset(Auth::user()->image != null? Auth::user()->image : 'uploads/user_default.jpg') }}" alt="User Image">
    <div>
        <p class="app-sidebar__user-name" ><a style="color: white" class="text-decoration-none" href="{{ route('user.info') }}">{{ ucfirst(auth()->user()->name) ?? 'N/A' }}</a></p>
        <p class="app-sidebar__user-designation">{{ ucfirst(auth()->user()->type) ?? 'N/A' }}</p>
    </div>
</div>
<ul class="app-menu">
    <li><a class="app-menu__item {{ Request::is('secure/dashboard')?'active':'' }}" href="{{ route('dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    <li class="treeview {{ Request::is('secure/product*') ?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/product*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-archive"></i><span class="app-menu__label">Product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item {{ Request::is('secure/product')?'active':'' }}" href="{{ route('product.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Product List</span></a></li>
            @can('app.product.create')
            <li><a class="treeview-item {{ Request::is('secure/product/create')?'active':'' }}" href="{{ route('product.create') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Add New Product</span></a></li>
            @endcan
        </ul>
    </li>

    <li class="treeview {{ Request::is('secure/orders*')?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/orders*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-hand-pointer-o"></i><span class="app-menu__label">Orders</span><i class="treeview-indicator fa fa-angle-right"></i></a>
        <ul class="treeview-menu">
            <li><a class="treeview-item {{ Request::is('secure/orders/pending')?'active':'' }}" href="{{ route('orders.pending') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Pending</span></a></li>
            <li><a class="treeview-item {{ Request::is('secure/orders/confirmed')?'active':'' }}" href="{{ route('orders.confirmed') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Confirmed</span></a></li>
            <li><a class="treeview-item {{ Request::is('secure/orders/processing')?'active':'' }}" href="{{ route('orders.processing') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Processing</span></a></li>
            <li><a class="treeview-item {{ Request::is('secure/orders/shipped')?'active':'' }}" href="{{ route('orders.shipped') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Shipped</span></a></li>
            <li><a class="treeview-item {{ Request::is('secure/orders/delivered')?'active':'' }}" href="{{ route('orders.delivered') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Delivered</span></a></li>
            <li><a class="treeview-item {{ Request::is('secure/orders/canceled')?'active':'' }}" href="{{ route('orders.canceled') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Canceled</span></a></li>
        </ul>
    </li>
</ul>
