<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-9 d-none d-lg-block">
            <div class="g-3 d-grid x5-md">
                <div class="footer-list">
                    <div class="dt"><a href="#footer">ニュース</a></div>
                    <div class="dd">
                        @foreach ($dailyinfoCategoryList as $item)
                        <a href="{{ route('get_dailyinfo_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="footer-list">
                    <div class="dt"><a href="{{ route('get_town_index_route') }}">POSTEタウン</a></div>
                </div>
                <div class="footer-list">
                    <div class="dt"><a href="#footer">暮らしの知恵</a></div>
                    <div class="dd">
                        @foreach ($lifetipCategoryList as $item)
                        <a href="{{ route('get_lifetip_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="footer-list">
                    <div class="dt"><a href="#footer">クラシファイド</a></div>
                    <div class="dd">
                        <a href="{{ URL::to('personal-trading') }}">個人売買</a>
                        <a href="{{ URL::to('real-estate') }}">不動産情報</a>
                        <a href="{{ URL::to('job-searching') }}">お仕事探し</a>
                        <a href="{{ URL::to('job-searching') }}">情報掲示板</a>
                    </div>
                </div>
                <div class="footer-list">
                    <div class="dt"><a href="{{ route('get_business_index_route') }}">進出企業</a></div>
                </div>
            </div>
        </div>
        <div class="col-12 px-5 px-lg-3 col-lg-3">
            <div class="row gap-3">
                <div class="col-6 mb-3">
                    <a href="{{ env('POSTE_FACEBOOK_URL') }}" class="btn-fb">
                        <img src="{{ asset('images/poste/facebook.png') }}" class="img-fluid">
                    </a>
                </div>
                <div class="col-6 mb-3">
                    <a href="{{ env('POSTE_LINE_URL') }}" class="btn-line">
                        <img src="{{ asset('images/poste/line.png') }}" class="img-fluid">
                    </a>
                </div>
                <div class="col-12 mb-3 text-center">
                    <a href="#footer"><img src="{{ asset('images/poste/logo.png') }}" class="img-fluid p-1 bg-white" style="margin: 0 auto; min-width: 120px; border-radius: 5px;"></a>
                </div>
            </div>
            <div class="row m-0 footer-list f-end">
                <div class="col-12 p-0 text-center"><a href="{{ route('get_contact_route') }}" class="t-bold">問い合わせ</a></div>
            </div>
        </div>
    </div>
</div>
