@extends('www.layouts.master')

@section('content')
<div id="second-page">
    <div id="menu" class="mb-4">
        <div class="container">
            <div id="nav-opt1" class="swiper-container py-15 pb-20">
                @include('www.pages.lifetip.cate-menu')
                
                <div class="swiper-scrollbar visible-xs visible-sm"></div>
            </div>
        </div>
    </div>
    
    <div id="category-title" class="bg-white mb-4 py-3">
        <h2 class="text-center">
            <img src="{{ App\Models\Base::getUploadURL($categoryItem->getIcon->name, $categoryItem->getIcon->dir) }}" alt="{{ $categoryItem->name.','.$categoryItem->slug }}" alt="{{ $categoryItem->name }}">
            {{ $categoryItem->name }}
        </h2>
    </div>
    
    {{-- Main content --}}
    <div class="container">
        <div id="main-section" class="d-grid x3 gx-4">
            <div id="articles-section" class="g-col-lg-2 g-col-3 mb-4">
                <div class="g-4 d-grid x2">
                    @foreach ($articleList as $item)    
                    {{-- Lifetip Item --}}
                    <div class="article-item rounded bg-white shadow-sm g-col-2 g-col-md-1 position-relative">
                        <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                            <div class="article-image">
                                <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                            </div>
                            <div class="description px-2">
                                <h2 class="px-2 mb-4">{{ $item->name }}</h2>
                                <div class="p-description px-2">
                                    {!! $item->description !!}
                                </div>
                            </div>
                            <p class="p-date-place">
                                <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                            </p>
                        </a>
                    </div>
                    {{-- End Lifetip Item --}}
                    @endforeach
                </div>
            </div>
            <div id="pagination-section" class="g-col-3">
                {{ $articleList->links() }}
            </div>
            <div id="ranking-section" class="g-col-3 gc-order-lg-3 gr-order-lg-1 g-col-lg-1 mb-4">
                <div class="sticky-top sticky-top-except-nav">
                    <div id="lifetip-ranking" class="mb-4 shadow-sm">
                        <h2 class="p-2 text-center text-white bg-poste rounded-top m-0">今日のアクセスランキング</h2>
                        
                        <div class="bg-white rounded-bottom rank-section overflow-hidden">
                            @foreach ($rankingList as $item)    
                            <div class="col-12 ranking-item px-0">
                                <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters p-3">
                                        <div class="col-5 p-0 overflow-hidden">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="col-7 pl-3 pr-0">
                                            <h2>{{ $item->name }}</h2>
                                            <p class="p-date-place p-0">
                                                <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div id="daily-recommend" class="mb-4 shadow-sm">
                        <div class="bg-secondary rounded rank-section overflow-hidden">
                            @forelse ($recommendList as $item)    
                            <div class="col-12 daily-item px-0">
                                <a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters p-3">
                                        <div class="col-5 p-0 overflow-hidden">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="col-7 pr-0 pl-3">
                                            <h2>{{ $item->name }}</h2>
                                            <p class="p-date-place p-0">
                                                <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @empty
                            <div class="col-12 daily-item py-4 text-center font-weight-bold text-white">
                                NO ARTICLES
                            </div>
                            @endforelse
                            
                            <a href="{{ route('get_dailyinfo_index_route') }}">
                                <h2 class="p-2 text-center text-white bg-dark rounded-bottom m-0"> \耳寄り情報をもっと見る/ </h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Main content --}}
        
        {{-- Poste Town List --}}
        {{--  <div id="town" class="bg-white mb-4 py-3">
            <h2 class="text-center mb-3">ポステのイチオシ！</h2>
            <div class="container">
                <div class="g-4 x2 x3-md x6-lg d-grid">
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                    <div class="town-item">
                        <a href="#">
                            <div class="div-image overflow-hidden mb-2">
                                <img class="img-fluid border border-light" src="{{ asset('images/poste/demo/town.jpg') }}">
                            </div>
                            <div class="title">
                                <h2>
                                    One More Pub Restaurant｜プノンペンのドイツ＆西洋料理レストラン
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- end Poste Town List --}}
    </div>
    
    @endsection