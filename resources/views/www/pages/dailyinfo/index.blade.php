@extends('www.layouts.master')

@section('content')
<div id="second-page">
    @isset($ad_dailyinfo_mobile_top_banner)
        <div class="ad dailyinfo-top-mobile d-lg-none mb-4">
            @foreach ($ad_dailyinfo_mobile_top_banner as $item)
                <a href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
                    <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid img-cover rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
                </a>
            @endforeach
        </div>
    @endisset
    
    <div id="menu" class="mb-4">
        <div class="container">
            <div id="nav-opt1" class="swiper-container py-15 pb-20">
                @include('www.pages.dailyinfo.cate-menu')

                <div class="swiper-scrollbar visible-xs visible-sm"></div>
            </div>
        </div>
    </div>

    <div id="category-title" class="bg-white mb-4 py-3">
        <h2 class="text-center">
            <img src="{{ App\Models\Base::getUploadURL($categoryItem->getIcon->name, $categoryItem->getIcon->dir) }}" alt="{{ $categoryItem->slug.','.$categoryItem->name}}" alt="{{ $categoryItem->name }}">
            {{ $categoryItem->name }}
        </h2>
    </div>

    {{-- Main content --}}
    <div class="container">
        <div id="main-section" class="d-grid x3 gx-4">
            <div id="articles-section" class="g-col-lg-2 g-col-3 mb-4">
                <div class="g-4 d-grid x2">

                    @foreach ($articleList as $item)

                    {{-- Aritlce Item --}}
                    @if($loop->first)
                    <div class="article-item rounded bg-white shadow-sm overflow-hidden g-col-2 g-col-md-1 g-row-md-3">
                        <a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}">
                            <div class="article-image">
                                <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                            </div>
                            <div class="description pb-2 position-relative">
                                <h2 class="p-3 m-0">{{ $item->name }}</h2>
                                <div class="p-description px-3 pb-5">
                                    {!! $item->description !!}
                                </div>
                                <p class="p-date-place px-3 py-1">
                                    <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                </p>
                            </div>
                        </a>
                    </div>
                    @else
                    <div class="article-item rounded bg-white shadow-sm overflow-hidden g-col-2 g-col-md-1">
                        <a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}">
                            <div class="row no-gutters h-100">
                                <div class="col-7 px-3">
                                    <h2 class="pt-3 pb-5 m-0">{{ $item->name }} </h2>
                                    <p class="p-date-place px-3 py-1">
                                        <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                    </p>
                                </div>
                                <div class="col">
                                    <div class="article-image h-100">
                                        <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    {{-- End Aritlce Item --}}

                    @endforeach

                </div>
            </div>
            <div id="pagination-section" class="g-col-3">
                {{ $articleList->links() }}
            </div>
            <div id="ranking-section" class="g-col-3 gc-order-lg-3 gr-order-lg-1 g-col-lg-1 mb-4">
                <div class="sticky-top sticky-top-except-nav">
                    <div id="daily-ranking" class="mb-4 shadow-sm">
                        <h2 class="p-2 text-center text-white bg-poste rounded-top m-0">
                            {{ $categoryItem->id == 5 || $categoryItem->id == 6 ? 'プロモーション&イベントランキング' : 'ニュースランキング' }}
                        </h2>

                        <div class="bg-white rounded-bottom rank-section overflow-hidden">
                            @foreach ($rankingList as $item)

                            <div class="col-12 ranking-item px-0">
                                <a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters p-3">
                                        <div class="col-5 p-0 rounded overflow-hidden">
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

                            @endforeach

                        </div>
                    </div>

                    <div id="lifetip-recommend" class="mb-4 shadow-sm">
                        <div class="bg-secondary rounded-top rank-section overflow-hidden">
                            @foreach ($recommendList as $item)
                            <div class="col-12 lifetip-item px-0">
                                <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters p-3">
                                        <div class="col-5 p-0 rounded overflow-hidden">
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
                            @endforeach
                        </div>
                        <a href="#">
                            <h2 class="p-2 text-center text-white bg-dark rounded-bottom m-0"> \ 暮らしの知恵の記事をもっと読む / </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Main content --}}

    {{-- Poste Town List --}}
    {{-- <div id="town" class="bg-white mb-4 py-3">
        <h2 class="text-center mb-3">ポステのイチオシ！</h2>
        <div class="container">
            <div class="g-4 x2 x3-md x6-lg d-grid">
                <div class="town-item rounded">
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
