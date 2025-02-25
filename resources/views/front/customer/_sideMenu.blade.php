
    <div class="text-center">
        <img style="max-width: 200px; max-height: 200px;" src="{{ asset(auth()->user()->image != null? auth()->user()->image : 'uploads/user_default.jpg') }}" class="avatar img-circle img-thumbnail" alt="avatar">
    </div><br>

    <p class="text-center">Reward Point: {{($balance != null)?$balance->point: 0}}</p>


    <div class="sidebar">
        <div class="sidebar__item">
            <ul class="list-group">
                <li class="list-group-item">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-account')?'text-custom':'' }}" href="{{ route('account') }}">Profile</a></strong></span></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-orders*')?'text-custom':'' }}" href="{{ route('myorders') }}">Orders</a></strong></span> {{ $order_count }}</li>
                {{--<li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-reviews*')?'text-custom':'' }}" href="{{ route('my_reviews') }}">Reviews</a></strong></span> {{ $review_count }}</li>--}}
                <li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-returns*')?'text-custom':'' }}" href="{{ route('my_disputes') }}">Returns</a></strong></span> {{ $dispute_count }}</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong><a class="{{ Request::is('my-tickets*')?'text-custom':'' }}" href="{{ route('my_tickets') }}">Support Tickets</a></strong></span> {{ $ticket_count }}</li>
            </ul>
        </div>
    </div>

