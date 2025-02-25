<span>
    @php
        $total = 0;
    @endphp


    @if($cart != null)
        @foreach($cart as $item)


            @php
                $total += $item['quantity'] * $item['price'] ;
            @endphp

        @endforeach

    @endif
<div class="header__cart__price">item: <span>{{ $total }}/-</span></div>

</span>
