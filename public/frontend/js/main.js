"use strict";

(function ($) {
    /*------------------
        Preloader
    --------------------*/
    // $(window).on("load", function () {
    //     $(".loader").fadeOut();
    //     $("#preloder").delay(200).fadeOut("slow");

    //     /*------------------
    //         Gallery filter
    //     --------------------*/
    //     $(".featured__controls li").on("click", function () {
    //         $(".featured__controls li").removeClass("active");
    //         $(this).addClass("active");
    //     });
    //     if ($(".featured__filter").length > 0) {
    //         var containerEl = document.querySelector(".featured__filter");
    //         var mixer = mixitup(containerEl);
    //     }
    // });

    /*==========   flash sell  ==========*/

    /* $(function(){
        $('#hms_timer').countdowntimer({
            hours : 3,
            minutes :10,
            seconds : 10,
            size : "lg"
        });
    });*/

    /*==========   flash sell  ==========*/
    /*==========   main slider  ==========*/
    $(".slider-carousel").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: [
            '<i class="icofont-caret-left"></i>',
            '<i class="icofont-caret-right"></i>',
        ],
        animateOut: "fadeOut",
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });

    /*------------------
        Background Set
    --------------------*/
    $(".set-bg").each(function () {
        var bg = $(this).data("setbg");
        $(this).css("background-image", "url(" + bg + ")");
    });

    //Humberger Menu
    $(".humberger__open").on("click", function () {
        $(".humberger__menu__wrapper").addClass(
            "show__humberger__menu__wrapper"
        );
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on("click", function () {
        $(".humberger__menu__wrapper").removeClass(
            "show__humberger__menu__wrapper"
        );
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true,
    });

    /*-----------------------
        product zoom
    ------------------------*/
    if ($("#imgZoom").length > 0) {
        $("#imgZoom").ezPlus({
            zoomType: "inner",
            cursor: "crosshair",
            imageCrossfade: true,
            loadingIcon: "https://cdnjs.cloudflare.com/ajax/libs/ez-plus/1.2.1/spinner.gif",
        });
    }
    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            },
        },
    });

    $(".hero__categories__all").on("click", function () {
        $(".hero__categories ul").slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            },
        },
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data("min"),
        maxPrice = rangeSlider.data("max");
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val("$" + ui.values[0]);
            maxamount.val("$" + ui.values[1]);
        },
    });
    minamount.val("$" + rangeSlider.slider("values", 0));
    maxamount.val("$" + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $(".n-select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $(".product__details__pic__slider img").on("click", function () {
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".product__details__pic__item--large").attr("src");
        if (imgurl != bigImg) {
            $(".product__details__pic__item--large").attr({
                src: imgurl,
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on("click", ".qtybtn", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
            /*var newVal = parseFloat(oldValue) + 1;*/
            if (oldValue < 5) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                newVal = 5;
            }
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });
    /*test*/
    /*test*/
})(jQuery);

/*-------------------
		top button
	--------------------- */

//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 200 ||
        document.documentElement.scrollTop > 200
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// Sticky nav js

$(document).on("scroll", function () {
    if ($(document).scrollTop() > 100) {
        $("#stickynav").addClass("sticky");
    } else {
        $("#stickynav").removeClass("sticky");
    }
});

/*Category*/
(function ($, window, document, undefined) {
    var pluginName = "jqueryAccordionMenu";
    var defaults = {
        speed: 300,
        showDelay: 0,
        hideDelay: 0,
        singleOpen: true,
        clickEffect: true,
    };

    function Plugin(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }
    $.extend(Plugin.prototype, {
        init: function () {
            this.openSubmenu();
            this.submenuIndicators();
            if (defaults.clickEffect) {
                this.addClickEffect();
            }
        },
        openSubmenu: function () {
            $(this.element)
                .children("ul")
                .find("li")
                .bind("click touchstart", function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    if ($(this).children(".submenu").length > 0) {
                        if (
                            $(this).children(".submenu").css("display") ==
                            "none"
                        ) {
                            $(this)
                                .children(".submenu")
                                .delay(defaults.showDelay)
                                .slideDown(defaults.speed);
                            $(this)
                                .children(".submenu")
                                .siblings("a")
                                .addClass("submenu-indicator-minus");
                            if (defaults.singleOpen) {
                                $(this)
                                    .siblings()
                                    .children(".submenu")
                                    .slideUp(defaults.speed);
                                $(this)
                                    .siblings()
                                    .children(".submenu")
                                    .siblings("a")
                                    .removeClass("submenu-indicator-minus");
                            }
                            return false;
                        } else {
                            $(this)
                                .children(".submenu")
                                .delay(defaults.hideDelay)
                                .slideUp(defaults.speed);
                        }
                        if (
                            $(this)
                                .children(".submenu")
                                .siblings("a")
                                .hasClass("submenu-indicator-minus")
                        ) {
                            $(this)
                                .children(".submenu")
                                .siblings("a")
                                .removeClass("submenu-indicator-minus");
                        }
                    }
                    window.location.href = $(this).children("a").attr("href");
                });
        },
        submenuIndicators: function () {
            if ($(this.element).find(".submenu").length > 0) {
                $(this.element)
                    .find(".submenu")
                    .siblings("a")
                    .append(
                        "<span class='submenu-indicator'> <i class=\"icofont-simple-right\"></i> </span>"
                    );
            }
        },
        addClickEffect: function () {
            var ink, d, x, y;
            $(this.element)
                .find("a")
                .bind("click touchstart", function (e) {
                    $(".ink").remove();
                    if ($(this).children(".ink").length === 0) {
                        $(this).prepend("<span class='ink'></span>");
                    }
                    ink = $(this).find(".ink");
                    ink.removeClass("animate-ink");
                    if (!ink.height() && !ink.width()) {
                        d = Math.max(
                            $(this).outerWidth(),
                            $(this).outerHeight()
                        );
                        ink.css({
                            height: d,
                            width: d,
                        });
                    }
                    x = e.pageX - $(this).offset().left - ink.width() / 2;
                    y = e.pageY - $(this).offset().top - ink.height() / 2;
                    ink.css({
                        top: y + "px",
                        left: x + "px",
                    }).addClass("animate-ink");
                });
        },
    });
    $.fn[pluginName] = function (options) {
        this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });
        return this;
    };
})(jQuery, window, document);

jQuery(document).ready(function () {
    jQuery("#jquery-accordion-menu").jqueryAccordionMenu();
    jQuery(".colors a").click(function () {
        if ($(this).attr("class") != "default") {
            $("#jquery-accordion-menu").removeClass();
            $("#jquery-accordion-menu")
                .addClass("jquery-accordion-menu")
                .addClass($(this).attr("class"));
        } else {
            $("#jquery-accordion-menu").removeClass();
            $("#jquery-accordion-menu").addClass("jquery-accordion-menu");
        }
    });
});
/*Category*/
/*Category hover*/
$("#jquery-accordion-menu li").hover(function () {
    var isHovered = $(this).is(":hover");
    if (isHovered) {
        $(this).children("ul").stop().slideDown(300);
    } else {
        $(this).children("ul").stop().slideUp(300);
    }
});
/*Category hover*/

/*=========realtime cart total change============*/

/* $('.qty').on("change keyup", function() {
            var pr=$(this).parent().parent().parent().parent();
            var tot = pr.find('.price').val() * $(this).val();
            var cart_tot = pr.find('.total');
            console.log(cart_tot.val())
            cart_tot.val(tot);
            // cart_tot.val(tot);
        });*/

$(".dec").on("click", function () {
    var pr = $(this).parent().parent().parent().parent();
    var oldValue = $(this).parent().find(".qty").val();

    if (oldValue > 1) {
        var qty = parseFloat(oldValue) - 1;
    } else {
        qty = 1;
    }

    var tot = pr.find(".price").val() * qty;
    var cart_tot = pr.find(".total");
    cart_tot.val(tot);
});

$(".inc").on("click", function () {
    var pr = $(this).parent().parent().parent().parent();
    var oldValue = $(this).parent().find(".qty").val();

    if (oldValue < 5) {
        var qty = parseFloat(oldValue) + 1;
    } else {
        qty = 5;
    }

    var tot = pr.find(".price").val() * qty;
    var cart_tot = pr.find(".total");
    cart_tot.val(tot);
});

/*=========realtime cart total change==============*/
