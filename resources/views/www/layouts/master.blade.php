<!doctype html>
<html lang="ja-jp">
<head>
    @include('www.includes.stylesheets')
</head>
<body {{ isset($scrollspy) && $scrollspy == 1 ? "data-spy=scroll data-target=.scrollspy-bar data-offset=150"  : '' }}>
    <div id="fb-root"></div>

    {{-- Header --}}
    <div id="header">
        @include('www.includes.header')
    </div>
    {{-- End Header --}}

    {{-- Navbar Header --}}
    <div id="mainNav" class="bg-white shadow-sm mb-4 sticky-top">
        @include('www.includes.navbar-header')
        @yield('sticky-menu')
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

    {{-- Mun Ruoi --}}
    @include('www.includes.munruoi')
    {{-- End Mun Ruoi --}}

    @include('www.includes.scripts')
</body>
</html>
