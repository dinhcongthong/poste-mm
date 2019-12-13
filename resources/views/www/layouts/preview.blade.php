<!doctype html>
<html lang="ja-jp">
<head>
    <title>{{ isset($pageTitle) && !empty($pageTitle) ? $pageTitle : 'Please check Controller.php to set PageTitle' }}</title>

    <link rel="shortcut icon" href="{{ asset('images/poste/favicon.ico') }}">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap 4.0.1 CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    {{-- FontAwesome 5.3.1 --}}
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome-5.4.1/css/all.min.css') }}">
    {{-- Material Icon --}}
    <link rel="stylesheet" href="{{ asset('vendors/material-icon/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/material-icon/css/bs4-addition.css') }}">
    {{-- Lining CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/lining/lining.css') }}">
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/swipper-4.4.1/css/swiper.min.css') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:100,300,400,500,700,800,900&amp;subset=japanese,vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Common CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('www/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('www/css/grid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('www/css/custom.css') }}">

    {!! isset($stylesheets) ? $stylesheets : '' !!}

    @yield('stylesheets')
</head>
<body>
    <div id="fb-root"></div>

    {{-- Header --}}
    <div id="header">
        @include('www.includes.header')
    </div>
    {{-- End Header --}}

    {{-- Navbar Header --}}
    <div id="mainNav" class="bg-white shadow-sm mb-4 sticky-top">
        @include('www.includes.navbar-header')
    </div>
    {{-- Navbar Header --}}

    {{-- Main top banner on mobile --}}
    {{-- End Main top banner on mobile --}}
    <div id="body-main-content">
        @yield('content')
    </div>

    {{-- Footer --}}
    <div id="footer" class="footer py-4">
        @include('www.includes.footer')
    </div>
    {{-- End Footer --}}

    {{-- Logout Form --}}
    @auth
    @include('auth.logout-form')
    @endauth
    {{-- End Logout Form --}}

    {{-- Jquery --}}
    <script type="text/javascript" src="{{ asset('vendors/jquery/jquery-3.3.1.min.js') }}"></script>
    {{-- Popperjs for BS4 --}}
    <script src="{{ asset('js/popper.min.js') }}"></script>
    {{-- BS4 --}}
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- FontAwesome 5.3.1 --}}
    <script src="{{ asset('vendors/fontawesome-5.4.1/js/all.min.js') }}"></script>
    {{-- Lining Js --}}
    <script src="{{ asset('vendors/lining/lining.js') }}"></script>
    {{-- Swiper Js --}}
    <script src="{{ asset('vendors/swipper-4.4.1/js/swiper.min.js') }}"></script>
    {{-- Twitter Wiget Js --}}
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    {{-- Line Share JS --}}
    <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
    
    <script>var base_url = "{{ URL::to('/') }}"</script>
    {!! isset($scripts) ? $scripts : '' !!}

    @yield('scripts')
</body>
</html>
