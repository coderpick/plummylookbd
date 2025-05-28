<div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="max-width: 48px; max-height: 48px;" src="{{ asset(Auth::user()->image != null? Auth::user()->image : 'uploads/user_default.jpg') }}" alt="User Image">
    <div>
        <p class="app-sidebar__user-name" ><a style="color: white" class="text-decoration-none" href="{{ route('user.info') }}">{{ ucfirst(auth()->user()->name) ?? 'N/A' }}</a></p>
        <p class="app-sidebar__user-designation">{{ ucfirst(auth()->user()->type) ?? 'N/A' }}</p>
    </div>
</div>
<ul class="app-menu">
    @can('dashboard')
        <li><a class="app-menu__item {{ Request::is('secure/dashboard')?'active':'' }}" href="{{ route('dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
    @endcan
        @can('app.category.index')
            <li><a class="app-menu__item {{ Request::is('secure/category*')?'active':'' }}" href="{{ route('category.index') }}"><i class="app-menu__icon fa fa-th-large"></i><span class="app-menu__label">Categories</span></a></li>
        @endcan
        {{--@can('app.category.approve')
            <li><a class="app-menu__item {{ Request::is('secure/categories*')?'active':'' }}" href="{{ route('category.pending') }}"><i class="app-menu__icon fa fa-th-large"></i><span class="app-menu__label">Pending Categories</span></a></li>
        @endcan--}}
        @can('app.subCategory.index')
            <li><a class="app-menu__item {{ Request::is('secure/sub-category*')?'active':'' }}" href="{{ route('sub-category.index') }}"><i class="app-menu__icon fa fa-th"></i><span class="app-menu__label">Sub-Categories</span></a></li>
        @endcan
        @can('app.brand.index')
            <li><a class="app-menu__item {{ Request::is('secure/brand*')?'active':'' }}" href="{{ route('brand.index') }}"><i class="app-menu__icon fa fa-tag"></i><span class="app-menu__label">Brands</span></a></li>
        @endcan
    @can('app.product.index')
        <li class="treeview {{ Request::is('secure/product*') ?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/product*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-archive"></i><span class="app-menu__label">Product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item {{ Request::is('secure/product')?'active':'' }}" href="{{ route('product.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Product List</span></a></li>
                @can('app.product.create')
                <li><a class="treeview-item {{ Request::is('secure/product/create')?'active':'' }}" href="{{ route('product.create') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Add New Product</span></a></li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('app.product.flash')
        <li><a class="app-menu__item {{ Request::is('secure/flash-product*')?'active':'' }}" href="{{ route('flash.index') }}"><i class="app-menu__icon fa fa-bolt"></i><span class="app-menu__label">Flash Sale</span></a></li>
        <li><a class="app-menu__item {{ Request::is('secure/flash-banner')?'active':'' }}" href="{{ route('banner.index') }}"><i class="app-menu__icon fa fa-photo"></i><span class="app-menu__label">Flash Sale Banner</span></a></li>
    @endcan

    @can('app.order.index')
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
    @endcan

        {{--<li class="treeview {{ Request::is('secure/dispute*') || Request::is('secure/ticket*') ?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/dispute*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-comments-o"></i><span class="app-menu__label">Support</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('app.ticket.index')
                    <li><a class="treeview-item {{ Request::is('secure/tickets')?'active':'' }}" href="{{ route('ticket.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Support Tickets</span></a></li>
                @endcan
                @can('app.ticket.closed')
                    <li><a class="treeview-item {{ Request::is('secure/tickets/closed')?'active':'' }}" href="{{ route('ticket.closed') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Closed Support Tickets</span></a></li>
                @endcan
            </ul>
        </li>--}}

        {{--<li class="treeview {{ Request::is('secure/vendor*') || Request::is('secure/vendor*') ?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/vendor*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Vendors</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item {{ Request::is('secure/vendors')?'active':'' }}" href="{{ route('vendor.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Vendors</span></a></li>
                --}}{{--<li><a class="treeview-item {{ Request::is('secure/vendors/pending')?'active':'' }}" href="{{ route('vendor.pending') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Pending Vendors</span></a></li>--}}{{--
                <li><a class="treeview-item {{ Request::is('secure/vendors/blocked')?'active':'' }}" href="{{ route('vendor.blocked') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Blocked Vendors</span></a></li>
            </ul>
        </li>--}}

        {{--<li class="treeview {{ Request::is('secure/withdraw*') || Request::is('secure/withdraw*') ?'is-expanded':'' }}">
            <a class="app-menu__item {{ Request::is('secure/withdraw*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-dollar"></i><span class="app-menu__label">Withdraws</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item {{ Request::is('secure/withdraws')?'active':'' }}" href="{{ route('withdraw.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Withdraws</span></a></li>
                <li><a class="treeview-item {{ Request::is('secure/withdraws/pending')?'active':'' }}" href="{{ route('withdraw.pending') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Pending Withdraws</span></a></li>
                <li><a class="treeview-item {{ Request::is('secure/withdraws/processing')?'active':'' }}" href="{{ route('withdraw.processing') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Processing Withdraws</span></a></li>
                <li><a class="treeview-item {{ Request::is('secure/withdraws/completed')?'active':'' }}" href="{{ route('withdraw.completed') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Completed Withdraws</span></a></li>
                <li><a class="treeview-item {{ Request::is('secure/withdraws/rejected')?'active':'' }}" href="{{ route('withdraw.rejected') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Rejected Withdraws</span></a></li>
            </ul>
        </li>--}}

        @can('app.coupon.index')
            <li><a class="app-menu__item {{ Request::is('secure/coupon*')?'active':''  }}" href="{{ route('coupon.index') }}"><i class="app-menu__icon fa fa-eraser"></i><span class="app-menu__label">Coupons</span></a></li>
        @endcan
        @can('app.offer.index')
            <li><a class="app-menu__item {{ Request::is('secure/offer*')?'active':''  }}" href="{{ route('offer.index') }}"><i class="app-menu__icon fa fa-bullhorn"></i><span class="app-menu__label">Announcements</span></a></li>
        @endcan
        @can('app.search.index')
            <li><a class="app-menu__item {{ Request::is('secure/searches')?'active':''  }}" href="{{ route('searches') }}"><i class="app-menu__icon fa fa-search"></i><span class="app-menu__label">Searches</span></a></li>
        @endcan
        @can('app.click.index')
            <li><a class="app-menu__item {{ Request::is('secure/customer-click')?'active':''  }}" href="{{ route('customer_click') }}"><i class="app-menu__icon fa fa-mouse-pointer"></i><span class="app-menu__label">Customer Click</span></a></li>
        @endcan
        @can('app.customer.index')
            <li><a class="app-menu__item {{ Request::is('secure/customers')?'active':''  }}" href="{{ route('customer') }}"><i class="app-menu__icon fa fa-user-o"></i><span class="app-menu__label">Customers</span></a></li>
        @endcan
        @can('app.subscriber.index')
            <li><a class="app-menu__item {{ Request::is('secure/subscribers')?'active':''  }}" href="{{ route('subscribers') }}"><i class="app-menu__icon fa fa-bell"></i><span class="app-menu__label">Subscribers</span></a></li>
        @endcan

        @can('app.report.index')
            <li><a class="app-menu__item {{ Request::is('secure/report')?'active':''  }}" href="{{ route('report.create') }}"><i class="app-menu__icon fa fa-sticky-note"></i><span class="app-menu__label">Report</span></a></li>
        @endcan

        <!-- access control nav start-->
         <li class="treeview {{ Request::is('secure/user*') || Request::is('secure/roles*') ?'is-expanded':'' }}">
            <a class="app-menu__item" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-lock"></i><span class="app-menu__label">Access Controls</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('roles.index')
                    <li><a class="treeview-item {{ Request::is('secure/roles')?'active':'' }}" href="{{ route('roles.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Roles</span></a></li>
                @endcan
                @can('users.index')
                    <li><a class="treeview-item {{ Request::is('secure/user*')?'active':'' }}" href="{{ route('user.index') }}"><i class="icon fa fa-circle-o"></i><span class="app-menu__label">Users</span></a></li>
                @endcan
            </ul>
        </li>
        <!-- access control nav end-->

        @can('app.setting.index')
        <li class="treeview {{ Request::is('secure/setting*')?'is-expanded':'' }}"><a class="app-menu__item {{ Request::is('secure/setting*')?'active':'' }}" href=" " data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('app.slider.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/slider*')?'active':'' }}" href="{{ route('slider.index') }}"><i class="icon fa fa-circle-o"></i>Slider</a></li>
                @endcan
                @can('app.contact.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/contact')?'active':'' }}" href="{{ route('contact.index') }}"><i class="icon fa fa-circle-o"></i>Contact</a></li>
                @endcan
                @can('app.shipping.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/shipping')?'active':'' }}" href="{{ route('shipping.index') }}"><i class="icon fa fa-circle-o"></i>Shipping Charge</a></li>
                @endcan
                @can('app.link.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/link')?'active':'' }}" href="{{ route('link.index') }}"><i class="icon fa fa-circle-o"></i>Logo & Links</a></li>
                @endcan
                @can('app.meta.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/meta')?'active':'' }}" href="{{ route('meta.index') }}"><i class="icon fa fa-circle-o"></i>Site Title & Meta tags</a></li>
                @endcan
                @can('app.privacy.index')
                    <li><a class="treeview-item {{ Request::is('secure/setting/privacy')?'active':'' }}" href="{{ route('privacy.index') }}"><i class="icon fa fa-circle-o"></i>Privacy & Policy</a></li>
                @endcan
            </ul>
        </li>
        @endcan
</ul>
