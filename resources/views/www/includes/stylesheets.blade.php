<title>{{ isset($pageTitle) && !empty($pageTitle) ? $pageTitle : 'Please check Controller.php to set PageTitle' }}</title>

<link rel="shortcut icon" href="{{ asset('images/poste/favicon.ico') }}">

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Meta for SEO --}}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="{{ isset($pageDescription) ? $pageDescription : '' }}" />

<meta name="author" content="POSTEミャンマーで">

<meta name="robots" content="index, follow" />
<meta name="keywords" content="{{ $pageKeywords ?? '' }}" />

{{-- Facebook Plugin configuration --}}
{{-- You can use Open Graph tags to customize link previews. --}}
{{-- Learn more: https://developers.facebook.com/docs/sharing/webmasters --}}
<meta property="og:url"           content="{{ Request()->fullUrl() }}" />
<meta property="og:type"          content="{{ isset($pageType) ? $pageType : 'website' }}" />
<meta property="og:title"         content="{{ $pageTitle ?? '' }}" />
<meta property="og:description"   content="{{ isset($pageDescription) ? $pageDescription : '' }}" />
<meta property="og:image"         content="{{ $pageImage ?? '' }}" />

{{-- Bootstrap 4.0.1 CSS --}}
<link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
{{-- FontAwesome 5.3.1 --}}
<link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
{{-- Material Icon --}}
<link rel="stylesheet" href="{{ asset('vendors/material-icon/css/materialdesignicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/material-icon/css/bs4-addition.css') }}">
{{-- Lining CSS --}}
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/lining/lining.css') }}">
{{-- Swiper CSS --}}
<link rel="stylesheet" href="{{ asset('vendors/swiper/css/swiper.min.css') }}">
{{-- Bootstrap4 Dialog --}}
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-dialog/css/bootstrap-dialog.min.css') }}">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:100,300,400,500,700,800,900&amp;subset=japanese,vietnamese" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

{{-- Common CSS --}}
<link rel="stylesheet" type="text/css" href="{{ asset('www/css/grid.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('www/css/main.css') }}">

{!! isset($stylesheets) ? $stylesheets : '' !!}

@yield('stylesheets')

{{-- Global site tag (gtag.js) - Google Analytics --}}
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128597206-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-128597206-1');
</script>
