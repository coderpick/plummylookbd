<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ucfirst($title??'')}} @if(isset($title))-@endif @if(isset($meta) && $meta->title == !null) {{ucfirst($meta->title)}}@endif </title>
<link rel="shortcut icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}" />
@include('layouts.frontend._meta')
<!-- Css Styles -->
<link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/icofont.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/elegant-icons.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/nice-select.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/jquery.countdownTimer.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('frontend/css/style.css?v=1.3.0')}}" type="text/css">
<!-- Toastr CSS-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@stack('library-css')
@stack('custom-css')
