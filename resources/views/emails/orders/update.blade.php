@component('mail::message')
# Order Update Mail

Dear {{ ucfirst($order->user->name) }} <br>
@if ($order->status == 'delivered')
Thanks for shopping with us. <br>
@endif
Your Order ({{ $order->order_number }}) has been {{ $order->status }} {{($order->payment_type == 'cash')? 'via Cash on delivery.':'.'}}  <br>
@if ($order->status != 'delivered')
You will be updated with another email soon. <br>
@endif

Thanks,<br>
{{ config('app.name') }}


*This is an automated email, please don't reply.
@endcomponent
