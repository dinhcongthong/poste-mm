@extends('www.layouts.master')

@section('content')
@php
if($article->fee == App\Models\PosteTown::SALE_INFORMING && $article->end_date >= date('Y-m-d') && $article->start_date <= date('Y-m-d')) {
    $is_premium = true;
} else {
    if($article->end_free_date >= date('Y-m-d')) {
        $is_premium = true;
    } else {
        $is_premium = false;
    }
}
@endphp

<div id="shop-content" class="container mt-0 my-lg-4 px-0 px-lg-3">
    <div id="premium-detail-grid" class="d-grid x12 g-0 g-lg-4">
        <div id="premium-info-list-mobile" class="g-col-12 navbar navbar-dark bg-dark scrollspy-bar list-group sticky-top d-lg-none p-0 shadow-sm">
            <ul class="nav nav-pills nav-justified w-100 h-100">
                <li class="nav-item">
                    <a class="nav-link active" href="#about">
                        <i class="fas fa-bullhorn"></i>
                        情報
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features-detail-list">
                        <i class="fas fa-clipboard-list"></i>
                        概要
                    </a>
                </li>
                @if(count($promotion_list) > 0)
                <li class="nav-item">
                    <a class="nav-link" href="#promotion">
                        <i class="fas fa-gift"></i>
                        お負け
                    </a>
                </li>
                @endif
                @if(!in_array($article->category_id, array(70, 74)) && !$menuList->isEmpty())
                <li class="nav-item">
                    <a class="nav-link" href="#menu">
                        <i class="fas fa-layer-group"></i>
                        メニュー
                    </a>
                </li>
                @endif
                @if(!$general_images->isEmpty())
                <li class="nav-item">
                    <a class="nav-link" href="#gallery">
                        <i class="far fa-images"></i>
                        写真
                    </a>
                </li>
                @endif
                @if(!empty($article->map))
                <li class="nav-item">
                    <a class="nav-link" href="#map">
                        <i class="fas fa-map-marked-alt"></i>
                        マップ
                    </a>
                </li>
                @endif
            </ul>
        </div>
        {{-- Category List swiper --}}
        <div class="g-col-12 mb-2 mb-lg-0">
            <div class="w-100">
                <div id="header-cate-list" class="swiper-container pb-3 pb-lg-0">
                    @include('www.pages.town.cate-swiper')
                </div>
            </div>
        </div>
        {{-- End Category List swiper --}}

        {{-- Article Category Item --}}
        <div class="g-col-12 wrapper bg-white text-center py-4 category-icon">
            <img src="{{ App\Models\Base::getUploadURL($article->getCategory->getIcon->name, $article->getCategory->getIcon->dir) }}" alt="{{ $article->getCategory->name }}">
            {{ $article->getCategory->name }}
        </div>
        {{-- End Article Category Item --}}

        {{-- Basic Info  --}}
        <div id="shop-basic-info" class="g-col-12 wrapper overflow-hidden row m-0 pb-1 pb-lg-0 town3">
            @include('www.pages.town.detail.basic-info')
        </div>
        {{-- End Basic Info  --}}


        <div id="shop-premium-info" class="nested x12 g-col-12 g-3 g-lg-4 p-3 p-lg-0">
            {{-- Premium Sidebar  --}}
            @if($is_premium)
            <div id="scrollspy" class="g-col-3 d-none d-lg-block">
                @include('www.pages.town.detail.sidebar')
            </div>
            @endif
            {{-- End Premium Sidebar  --}}


            <div class="nested x12 g-col-12  {{ $is_premium ? 'g-col-lg-9' : '' }}">
                <div class="premium-info nested x12 g-col-12">
                    {{-- Description --}}
                    @if($is_premium)
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="about">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-bullhorn mr-3"></i>概要</h3>
                            <div class="p-3 p-lg-4">
                                {!! nl2br(e($article->description)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- End Description --}}

                    {{-- Features Details --}}
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="features-detail-list">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-clipboard-list mr-3"></i>詳細</h3>
                            @include('www.pages.town.detail.features.index')
                        </div>
                    </div>
                    {{-- End Features Details --}}

                    {{-- Premium Area --}}
                    @if($is_premium)
                    {{-- Promotionn List --}}
                    @if(count($promotion_list) > 0)
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="promotion">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-gift mr-3"></i>耳寄り情報
                                <div class="btn-group ml-auto">
                                    <button class="btn btn-sm btn-outline-primary px-3 py-0 btn-prev"><i class="fas fa-angle-left"></i></button>
                                    <button class="btn btn-sm btn-outline-primary px-3 py-0 btn-next"><i class="fas fa-angle-right"></i></button>
                                </div>
                            </h3>
                            @include('www.pages.town.detail.promotion-list')
                        </div>
                    </div>
                    @endif
                    {{-- End Promotionn List --}}

                    {{-- Menu --}}
                    @if(!in_array($article->category_id, array(70, 74)) && (!$menuList->isEmpty() || !$pdf_list->isEmpty()))
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="menu">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-layer-group mr-3"></i>メニュー</h3>

                            @include('www.pages.town.detail.menu')
                        </div>
                    </div>
                    @endif
                    {{-- End Menu --}}

                    {{-- Gallery --}}
                    @if(!$general_images->isEmpty())
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="gallery">
                            <h3 class="px-3 px-lg-4 py-3"><i class="far fa-images mr-3"></i>写真</h3>
                            @include('www.pages.town.detail.gallery')
                        </div>
                    </div>
                    @endif
                    {{-- End Gallery --}}

                    {{-- Map --}}
                    @if(!empty($article->map))
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="map">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-map-marked-alt mr-3"></i>マップ</h3>
                            @if(strpos($article->map, ','))
                            <iframe width="100%" name="frame-map" id="frame-map" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&q={{ $article->map }}" allowfullscreen></iframe>
                            @else
                            <iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&q=place_id:{{ $article->map }}" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>
                    @endif
                    {{-- End Map --}}

                    @endif
                    {{-- End Premium Area --}}

                </div>

            </div>

        </div>
    </div>
</div>



{{-- modal edit form --}}
@include('www.pages.town.detail.modal-feedback')

<!-- extension content -->
<div id="shop-recommend" class="g-col-12"></div>
<div id="shop-bottom-nav"></div>

{{-- mobile navigator --}}
<div class="premium-nav-mobile bg-grey d-flex d-lg-none flex-wrap accordion">
    @include('www.pages.town.mobile-navigator')
</div>
{{-- end mobile navigator --}}
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('vendors/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(function () {
            $('[data-toggle="popover"]').popover()
        })

        $('#working-time-popover').popover({
            html: true,
            content: '<dl class="row"><dt class="col-5">123</dt><dd class="col-7">124</dd>',
                animation: true,
                container: 'body',
                placement: 'right',
                title: 'Hours'
            });

            var swiper = new Swiper('.shop-feature .swiper-container',{
                slidesPerView: 'auto',
                spaceBetween: 14,
                grabCursor: true,
                watchOverflow: true,
                scrollbar: {
                    el: '.swiper-scrollbar',
                    draggable: true,
                },
            });

            var swiper = new Swiper('#promo-slider .swiper-container',{
                slidesPerView: 2.5,
                spaceBetween: 14,
                grabCursor: true,
                watchOverflow: true,
                pagination: {
                    el: '#promotion .pagination',
                    type: 'bullets',
                },
                navigation: {
                    nextEl: '#promotion h3 .btn-next',
                    prevEl: '#promotion h3 .btn-prev',
                },
                mousewheel: {
                    invert: true,
                },
                breakpoints: {
                    576: {
                        slidesPerView: 1.5,
                    },
                },
            });

            $('#general-list').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]

                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function (item) {
                        return item.el.attr('title') + '<small>by Poste-mm.com</small>';
                    }
                },
                zoom: {
                    enabled: true,
                    duration: 500
                }
            });

            $('#gallerybox').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var albums = button.data('albums') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find(albums).tab('show')
            });
        });
    </script>
    @endsection
