@component('mail::message')
    # Order Place Mail

    Dear {{ ucfirst($order->user->name) }},
    Your order {{ $order->order_number }} has been placed.
    Total payable amount is Tk {{ $order->amount }} .
    @if ($order->payment_type == 'cash')
    Plz, Wait for confirmation
    @else
    Plz, Pay to confirm.
    @endif


    Thanks
    {{ config('app.name') }}


    *This is an automated email, please don't reply.
@endcomponent
