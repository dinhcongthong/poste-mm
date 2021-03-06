@extends('www.layouts.preview')

@section('content')
<div id="detail-page">
    <div class="container">
        <div id="menu" class="mb-4">
            <div id="nav-opt1" class="swiper-container py-15 pb-20">
                @include('www.pages.lifetip.cate-menu')
                
                <div class="swiper-scrollbar visible-xs visible-sm"></div>
            </div>
        </div>
        <div id="breadcrumb" class="mb-4 d-none d-md-block">
            <ol class="breadcrumb  bg-white">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('get_lifetip_index_route') }}">Lifetip</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $categoryItem->name }}</li>
            </ol>
        </div>
        <div id="main-content" class="d-grid x3 g-4 mb-4">
            <div class="g-col-3 g-col-lg-2">
                <div id="article-conetnt" class="bg-white rounded p-4 mb-4">
                    <div class="article-title mb-3">
                        <h2 class="fw-bolder">{{ $article->name }}</h2>
                        <div class="clearfix" id="social-share-button">
                            @include('www.includes.social-share-button')
                        </div>
                        <p class="clearfix">
                            <span class="float-left">
                                <img src="{{ App\Models\Base::getUploadURL($categoryItem->getIcon->name, $categoryItem->getIcon->dir) }}" alt="{{ $categoryItem->name }}">
                                {{ $categoryItem->name }}
                            </span>
                            <span class="float-right">
                                {{ date('Y年m月d日', strtotime($article->published_at)) }} 
                            </span>
                        </p>
                        <hr class="w-50 m-auto">
                    </div>
                    <div class="article-thumbnail mb-3">
                        <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir) }}" alt="{{ $article->name.','.$categoryItem->name }}">
                    </div>
                    <div id="detail-content">
                        {!! $contentOb->content !!}
                    </div>
                    <div class="content-pagination mt-3">
                        @if (!empty($paginate['nextTitle']))
                        <a href="{{ $paginate['hrefNext'] }}">
                            <p class="w-100 next-paragraph text-center">
                                <b>【次のページ】</b> <br/>
                                {{ $paginate['nextTitle'] }}
                            </p>
                        </a>
                        @endif
                        @if($paginate['totalPage'] > 1)
                        <ul class="pagination justify-content-center">
                            <li class="page-item  {{ !empty($paginate['hrefPrev']) ? '' : 'disabled' }} mx-1">
                                <a class="page-link" href="{{ !empty($paginate['hrefPrev']) ? $paginate['hrefPrev'] : '#' }}"><</a>
                            </li>
                            @for ($i = 0; $i < $paginate['totalPage']; $i++)
                            <li class="page-item {{ $paginate['currentPage'] == $i ? 'disabled' : '' }} mx-1">
                                <a class="page-link" href="{{ route('get_lifetip_detail_route', $article->slug.'-'.$article->id).'?page='.($i + 1) }}">{{ $i + 1 }}</a>
                            </li>
                            @endfor
                            <li class="page-item {{ !empty($paginate['hrefNext']) ? '' : 'disabled' }} mx-1">
                                <a class="page-link" href="{{ $paginate['hrefNext'] }}">></a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div id="recommend-content" class="bg-white p-4 rounded">
                    <h2 class="text-center fw-bolder text-poste">あわせて読みたい</h2>
                    
                    <div class="g-4 d-grid x2 x4-md">
                        @foreach ($relatedtList as $item)
                        <div class="recommend-item">
                            <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                                <div class="div-image overflow-hidden mb-2 rounded media-wrapper-1x1">
                                    <img class="img-cover rounded" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                </div>
                                <div class="title">
                                    <h2>
                                        {{ $item->name }}
                                    </h2>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="right-side" class="g-col-3 g-col-lg-1">
                <div class="d-grid x2 g-4 mb-4">
                    <div id="lifetip-ranking" class="g-col-2 g-col-md-1 g-col-lg-2">
                        <h2 class="px-2 py-3 text-center bg-poste text-white rounded-top m-0">アクセスランキング</h2>
                        
                        <div class="bg-white rounded-bottom rank-section border border-light">
                            @foreach ($rankingList as $item)    
                            <div class="col-12 ranking-item px-0">
                                <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters py-3">
                                        <div class="col pl-3 pr-1 rounded overflow-hidden">
                                            <img class="img-cover rounded" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="col pr-3 pl-1">
                                            <h2>{{ $item->name }}</h2>
                                            <p class="p-date-place">
                                                <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    
                    <div id="newest-lifetip" class="g-col-2 g-col-md-1 g-col-lg-2">
                        <h2 class="px-2 py-3 text-center text-white bg-poste rounded-top m-0">暮らしの知恵の新着記事</h2>
                        
                        <div class="bg-white rounded-bottom rank-section border border-light">
                            @foreach ($newsestList as $item)    
                            <div class="col-12 newest-item px-0">
                                <a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="row no-gutters py-3">
                                        <div class="col pl-3 pr-1 rounded overflow-hidden">
                                            <img class="img-cover rounded" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="col pr-3 pl-1">
                                            <h2>{{ $item->name }}</h2>
                                            <p class="p-date-place">
                                                <span>{{ date('Y-m-d', strtotime($item->published_at)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="sticky-top my-sticky-top d-sm-none d-lg-block">
                    <div class="cinema bg-dark p-2">
                        <div class="cinema-item">
                            <img src="{{ asset('images/poste/demo/cinema.jpg') }}" class="img-cover">
                            <div class="cinema-caption p-4 d-flex flex-column">
                                <div class="cap">
                                    <a href="#" class="btn btn-sm btn-danger mb-2 mx-auto">More Info...</a>
                                    <h5 class="text-center font-weight-bold">ルイスと不思議の時計【今週のシネマ】</h5>
                                    <p class="text-center small mb-4">公開日: 2018/09/29</p>
                                </div>
                                <p class="h-100 m-0" style="overflow-y: auto;">
                                    人里離れた雪山深くの山頂に住んでいる主人公のイエティ。イエティはもじゃもじゃした毛に包まれており、おっちょこちょいだけど優しい心を持っている雪男。そんな雪山に住んでいる雪男のなかで人間は小さな足を持つ伝説の生き物「スモールフット」と呼ばれている。ある日、イエティはそんな伝説の人間ミーゴと奇跡の出会いを果たす。イエティとミーゴは共に冒険を始め、イエティはミーゴの暮らしている人間の街へと辿り着く。イエティは人間を伝説と思っていたが、実は人間の中では雪男であるイエティが伝説となっているということを初めて知る。そんな中、街では大騒動が起きており大変な状況に……。その大騒動の理由は一体何故なのか？ その理由は雪山に住むものと人間の間にはある秘密があった
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="town-list" class="g-col-3 p-2 p-md-3 p-lg-4 bg-white">
                <h2 class="text-center bg-info text-white p-3 fw-bold">プノンペンの注目スポット</h2>
                <div class="bg-secondary p-2 p-md-3 p-lg-4 g-2 g-lg-4 g-md-3 d-grid x1 x2-sm x3-md">
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="town-item bg-white rounded">
                        <a href="#">
                            <div class="row rounded">
                                <div class="col-5 pr-1">
                                    <div class="overflow-hidden rounded border border-light">
                                        <img class="img-cover" src="{{ asset('images/poste/demo/town.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-7 pl-0 py-2">
                                    <h2 class="px-2 m-0">ラウンジ琴（Lounge Koto）｜日本人ママのいるプノンペンのラウンジ</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div id="pr-lt" class="g-col-3">
                <div class="d-grid g-4 x1 x3-lg">
                    <div id="promotion" class="g-col-lg-2 bg-white p-4">
                        <h2 class="clearfix mb-4">
                            プノンペンの耳寄り情報
                            
                            <a class="float-right text-white p-2" href="">
                                もっと見る
                            </a>
                        </h2>
                        <ul class="pl-2 m-0" id="pr-list">
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    お肉好きの方、プノンペン随一のステーキハウスの最大50%オフをお見逃しなく！【NEW YORK STEAKHOUSE】
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div id="lt-cate-list">
                        <h2 class="heading rounded-top m-0">デイリーインフォ</h2>
                        <div class="d-grid x1 bg-white rounded-bottom">
                            @foreach ($dailyinfoCategoryList as $item)                                
                            <a href="{{ route('get_dailyinfo_category_route', $item->slug.'-'.$item->id) }}" class="p-3">
                                <img src="{{ App\Models\Base::getUploadURL($item->getIcon->name, $item->getIcon->dir) }}" alt="{{ $item->name }}">
                                {{ $item->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection