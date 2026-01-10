<meta name="description"
    content="@if (isset($meta_description) && $meta_description == !null) {{ $meta_description }}
@elseif(isset($description) && $description == !null) {{ $description }}
@elseif(isset($meta) && $meta->description == !null) {{ $meta->description }}
@else ' ' @endif">
<meta name="keywords"
    content="@if (isset($meta_keyword) && $meta_keyword == !null) {{ $meta_keyword }}
@elseif(isset($keyword)) {{ $keyword }}
@elseif(isset($meta) && $meta->keyword == !null) {{ $meta->keyword }} @else ' ' @endif">
<meta name="author" content="Plummy Look">
<!-- Open Graph Meta Tags -->
<meta property="og:title"
    content="{{ ucfirst($title ?? '') }} @if (isset($title)) - @endif @if (isset($meta) && $meta->title == !null) {{ ucfirst($meta->title) }} @endif">
<meta property="og:description"
    content="@if (isset($meta_description) && $meta_description == !null) {{ $meta_description }}
@elseif(isset($description) && $description == !null) {{ $description }}
@elseif(isset($meta) && $meta->description == !null) {{ $meta->description }}
@else ' ' @endif">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image"
    content="{{ asset(isset($link) && $link->logo != null ? $link->logo : 'uploads/default_logo.png') }}">
<!-- Twitter Card Meta Tags for Twitter Sharing -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title"
    content="{{ ucfirst($title ?? '') }} @if (isset($title)) - @endif @if (isset($meta) && $meta->title == !null) {{ ucfirst($meta->title) }} @endif">
<meta name="twitter:description"
    content="@if (isset($meta_description) && $meta_description == !null) {{ $meta_description }}
@elseif(isset($description) && $description == !null) {{ $description }}
@elseif(isset($meta) && $meta->description == !null) {{ $meta->description }}
@else ' ' @endif">
<meta name="twitter:image"
    content="{{ asset(isset($link) && $link->logo != null ? $link->logo : 'uploads/default_logo.png') }}">

<meta name="google-site-verification" content="eGWYqOIXFvuh5-fgv5KN397ZTiKsOOEggb_maL_aDn8" />


<link rel="canonical" href="{{ url()->current() }}">
