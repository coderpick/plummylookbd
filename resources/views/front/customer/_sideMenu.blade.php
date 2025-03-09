<div class="custom-thumbnail-main">
    <img style="max-width: 100px; max-height: 100px;" src="{{ asset(auth()->user()->image != null? auth()->user()->image : 'uploads/user_default.jpg') }}" class="avatar img-circle img-thumbnail custom-thumbnail" alt="avatar">
    <div>
        <h4>Reward Point</h4>
        <p class="">{{($balance != null)?$balance->point: 0}}</p>
    </div>
</div>




<div class="sidebar">
    <div class="sidebar__item">
        <ul class="list-group">

            <li class="list-group-item text-right active"><span class="pull-left"><a class="" href="{{ route('account') }}"><i class="fa fa-dashboard fa-1x"></i> Dashboard</a></span></li>

            <li class="list-group-item text-right"><span class="pull-left"><a class="{{ Request::is('my-account')?'text-custom':'' }}" href="{{ route('account') }}"><i class="fa fa-user fa-1x"></i> Profile Info</a></span></li>
            <li class="list-group-item text-right"><span class="pull-left"><a class="{{ Request::is('my-orders*')?'text-custom':'' }}" href="{{ route('myorders') }}"><i class="fa fa-cart-plus fa-1x"></i> My Orders</a></span> {{ $order_count }}</li>
            <li class="list-group-item"><span class="pull-left"><a class="{{ Request::is('my-orders*')?'text-custom':'' }}" href="{{ route('myorders') }}"><i class="fa fa-map-marker fa-1x"></i> Addresses</a></span></li>
            <li class="list-group-item"><span class="pull-left"><a class="{{ Request::is('my-orders*')?'text-custom':'' }}" href="{{ route('myorders') }}"><i class="fa fa-sign-out fa-1x"></i> Logout</a></span></li>


            {{--<li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-reviews*')?'text-custom':'' }}" href="{{ route('my_reviews') }}">Reviews</a></strong></span> {{ $review_count }}</li>--}}
            {{--<li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-returns*')?'text-custom':'' }}" href="{{ route('my_disputes') }}">Returns</a></strong></span> {{ $dispute_count }}</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-tickets*')?'text-custom':'' }}" href="{{ route('my_tickets') }}">Support Tickets</a></strong></span> {{ $ticket_count }}</li>--}}
        </ul>
    </div>
</div>