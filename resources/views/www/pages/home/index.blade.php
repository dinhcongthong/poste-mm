@extends('www.layouts.master')

@section('content')
    <div class="container">
        @isset($ad_home_mobile_top_list)
            {{-- Ad Home Top Mobile --}}
            <div class="d-lg-none mb-4">
                @foreach ($ad_home_mobile_top_list as $item)
                    <a href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
                        <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid img-cover rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
                    </a>
                @endforeach
            </div>
            {{-- End Ad Home Top Mobile --}}
        @endisset

        <div id="toppage-grid" class="wrapper gx-2 gx-lg-4 gy-4 px-2 py-3 p-lg-4 mb-4">
            {{-- News Section --}}
            <div id="news-section" class="nested gy-2 gy-lg-4" title="POSTEオリジナルニュース">
                @include('www.pages.home.news')
            </div>
            {{-- End News Section --}}

            {{-- Lifetips Section --}}
            <div id="life-tips-section" class="nested" title="暮らしの知恵">
                @include('www.pages.home.lifetip')
            </div>
            {{-- End Lifetips Section --}}

            {{-- Ad Top Side M & L --}}
            <div id="ads-top-side" class="d-none d-lg-block">
                <div class="sticky-top sticky-top-except-nav">
                    @foreach ($ad_home_pc_aside_top_l_list as $item)
                        <a id="top-side-L" href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" class="d-block rounded overflow-hidden shadow-sm hover mb-3" target="_blank">
                            <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-cover" alt="{{ $item->name.','.$item->description }}">
                        </a>
                    @endforeach
                    @foreach ($ad_home_pc_aside_top_m_list as $item)
                        <a href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" class="d-block rounded overflow-hidden shadow-sm hover mb-3 media-wrapper-3x1 top-side-M" target="_blank">
                            <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-cover" alt="{{ $item->name.','.$item->description }}">
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- End Ad Top Side M & L --}}

            {{-- Poste Town --}}
            <div id="town-section" class="nested my-4" title="POSTEタウン">
                @include('www.pages.home.poste-town')
            </div>
            {{-- End Poste Town --}}

            {{-- Bussiness --}}
            <div id="business-section" class="d-flex flex-column border bg-light p-2 p-lg-4 mb-4" title="POSTEビジネス">
                @include('www.pages.home.business')
            </div>
            {{-- End Bussiness --}}

            {{-- Ranking --}}
            <div id="sidebar" class="d-none d-lg-block">
                <div class="sticky-top sticky-top-except-nav">
                    {{-- News Ranking --}}
                    <div id="news-ranking-section" class="d-none d-lg-grid mb-4" title="注目ニュース">
                        @include('www.pages.home.news-ranking')
                    </div>
                    {{-- End News Ranking --}}

                    {{-- Home Bottom Banner on Pc --}}
                    <div class="mb-4 p-3 bg-grey rounded">
                        @foreach ($ad_home_pc_bottom_list as $item)
                            <a class="d-block ad-home-pc-bottom-banner" href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
                                <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid img-cover rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
                            </a>
                        @endforeach
                    </div>
                    {{-- End Home Bottom Banner on Pc --}}

                    {{-- Promotion - Event Ranking --}}
                    <div id="pr-ranking-section" class="d-none d-lg-grid" title="注目記事ランキング">
                        @include('www.pages.home.promotion-event-ranking')
                    </div>
                    {{-- End Promotion - Event Ranking --}}
                </div>
            </div>
            {{-- End Ranking --}}

            {{-- Promotion - Event --}}
            <div id="promotions-events-section" class="nested" title="耳寄り情報＆イベント関連情報">
                @include('www.pages.home.promotion-event')
            </div>
            {{-- End Promotion - Event --}}

            {{-- Classify Section --}}
            <div id="classify-section" class="nested x12 xr12 mt-3 mt-lg-0">

                {{-- Personal Trading --}}
                <div id="personal-trading" class="nested g-col-12 g-col-lg-6 g-row-3 g-row-lg-6 shadow-sm hover">
                    @include('www.pages.home.personal-trading')
                </div>
                {{-- End Personal Trading --}}

                {{-- Bullboard --}}
                <div id="bullboard" class="nested g-col-12 g-col-lg-6 g-row-3 g-row-lg-6 shadow-sm hover">
                    @include('www.pages.home.bullboard')
                </div>
                {{-- End Bullboard --}}

                {{-- Jobsearching --}}
                <div id="job-searching" class="nested g-col-12 g-col-lg-6 g-row-3 g-row-lg-6 shadow-sm hover">
                    @include('www.pages.home.job-searching')
                </div>
                {{-- End Jobsearching --}}

                {{-- RealEstate --}}
                <div id="real-estate" class="nested g-col-12 g-col-lg-6 g-row-3 g-row-lg-6 shadow-sm hover">
                    @include('www.pages.home.real-estate')
                </div>
                {{-- End RealEstate --}}

            </div>
            {{-- End Classify Section --}}

            {{-- Golf --}}
            {{-- <div id="golf-section" title="ミャンマーゴルフガイド" class="col-12 px-0">
            <a href="{{ route('construction_route') }}" class="golf-item nav-link p-0 bg-light text-dark font-weight-bold h-100">
            <div class="col-12 p-2 p-lg-4">
            <img src="{{ asset('images/poste/golf.png') }}" alt="Poste Myanmar Golf" class="img-cover rounded">
        </div>
        <div class="col-12 pb-2 pb-lg-4 caption">
        ミャンマーのヤンゴン、シェムリアップのゴルフ場を紹介！お問い合わせやご予約もこちらからどうぞ！
    </div>
</a>
</div> --}}
{{-- End Golf --}}

{{-- Cinema --}}
{{--  <div id="cinema-section" title="ミャンマー映画情報" class="p-2 p-lg-4 bg-dark">
<div class="cinema-item">
<img src="{{ asset('images/poste/demo/cinema.jpg') }}" class="img-cover">
<div class="cinema-caption p-4 d-flex flex-column">
<div class="cap">
<a href="{{ route('construction_route') }}" target="_blank" class="btn btn-sm btn-danger mb-2 mx-auto">More Info...</a>
<h5 class="text-center font-weight-bold">ルイスと不思議の時計【今週のシネマ】</h5>
<p class="text-center small mb-4">公開日: 2018/09/29</p>
</div>
<p class="h-100 m-0" style="overflow-y: auto;">
人里離れた雪山深くの山頂に住んでいる主人公のイエティ。イエティはもじゃもじゃした毛に包まれており、おっちょこちょいだけど優しい心を持っている雪男。そんな雪山に住んでいる雪男のなかで人間は小さな足を持つ伝説の生き物「スモールフット」と呼ばれている。ある日、イエティはそんな伝説の人間ミーゴと奇跡の出会いを果たす。イエティとミーゴは共に冒険を始め、イエティはミーゴの暮らしている人間の街へと辿り着く。イエティは人間を伝説と思っていたが、実は人間の中では雪男であるイエティが伝説となっているということを初めて知る。そんな中、街では大騒動が起きており大変な状況に……。その大騒動の理由は一体何故なのか？ その理由は雪山に住むものと人間の間にはある秘密があった
</p>
</div>
</div>
</div> --}}
{{-- End Cinema --}}

{{-- Lifetip --}}
{{--   <div id="lifenav-section" class="nested x12 xr5 g-2" title="暮らしの知恵">
@include('www.pages.home.lifetip-menu')
</div> --}}
{{-- End Lifetip --}}
</div>
</div>
@endsection

@section('scripts')
    {{-- @include('www.pages.home.line-popup') --}}
@endsection
