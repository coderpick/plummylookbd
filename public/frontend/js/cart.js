$(function () {
    $('.add-cart').click(function () {
        var url = $(this).attr('url');

        $.ajax({
            url : url,
            method : 'GET',

            success : function (data) {
                /*console.log('Success - ' + JSON.stringify(data));*/

                /*$('.cart__price').html(data.cart__price);*/
                $('.cart-count').html('<span class="count">'+ data.cart.length +'</span>');
                 toastr.success("Added to cart", { timeOut: 10, tapToDismiss: true })

            },

            error : function (data) {
                console.log('errors - ' + JSON.stringify(data));
            }
        });

    });
});
