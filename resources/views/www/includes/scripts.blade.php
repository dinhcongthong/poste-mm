{{-- Jquery --}}
<script type="text/javascript" src="{{ asset('vendors/jquery/jquery-3.3.1.min.js') }}"></script>
{{-- Popperjs for BS4 --}}
<script src="{{ asset('js/popper.min.js') }}"></script>
{{-- BS4 --}}
<script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
{{-- Lining Js --}}
<script src="{{ asset('vendors/lining/lining.js') }}"></script>
{{-- Swiper Js --}}
<script src="{{ asset('vendors/swiper/js/swiper.min.js') }}"></script>
{{-- Bootstrap4 Dialog --}}
<script src="{{ asset('vendors/bootstrap4-dialog/js/bootstrap-dialog.min.js') }}"></script>
{{-- Twitter Wiget Js --}}
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
{{-- Line Share JS --}}
<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>

<script>var base_url = "{{ URL::to('/') }}"</script>

{!! isset($scripts) ? $scripts : '' !!}

@yield('scripts')
