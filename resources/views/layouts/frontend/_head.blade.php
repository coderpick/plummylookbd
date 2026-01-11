<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ ucfirst($title ?? '') }} @if (isset($title))
        -
        @endif @if (isset($meta) && $meta->title == !null)
            {{ ucfirst($meta->title) }}
        @endif
</title>
<link rel="shortcut icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}" />
@include('layouts.frontend._meta')
@stack('product_price_schema')
<!-- Css Styles -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/icofont.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/elegant-icons.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/slicknav.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/jquery.countdownTimer.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/style.css?v=1.0') }}" type="text/css">
<!-- Toastr CSS-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@stack('library-css')
@stack('custom-css')

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P5QZHG53');</script>
<!-- End Google Tag Manager -->


