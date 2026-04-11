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

                 // GA4 add_to_cart event
                 if (data.added_product) {
                     window.dataLayer = window.dataLayer || [];
                     window.dataLayer.push({ ecommerce: null }); // Clear previous ecommerce data
                     window.dataLayer.push({
                         event: 'add_to_cart',
                         ecommerce: {
                             currency: 'BDT',
                             value: data.added_product.price,
                             items: [data.added_product]
                         }
                     });
                 }
            },

            error : function (data) {
                console.log('errors - ' + JSON.stringify(data));
            }
        });

    });
});
