<!doctype html>
<html lang="ja-jp">
<head>
    <title>{{ isset($pageTitle) && !empty($pageTitle) ? $pageTitle : 'Please check Controller.php to set PageTitle' }}</title>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Bootstrap 4.0.1 CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    {{-- FontAwesome 5.3.1 --}}
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome-5.4.1/css/all.min.css') }}">
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
</head>
<body>
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
    
    @yield('content')
    
    {{-- Footer --}}
    <div id="footer" class="footer py-4">
        @include('www.includes.footer')
    </div>
    {{-- End Footer --}}
    
    {{-- Logout Form --}}
    @if(Auth::check())
    @include('auth.logout-form')
    @endif
    {{-- End Logout Form --}}
    
</body>
</html>