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
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1367304497680607');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1367304497680607&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


