@extends('www.layouts.master')

@section('content')
       <div class="container-fluid bg-white min-vh-100" id="grand-wrapper">
        <div id="section-1" class="row">
            <div class="container">
                <div class="row align-items-center my-5">
                    <div class="col-12 col-md-3 my-3">
                        <img src="{{ asset('customer/vrmyanmar/logo.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 col-md-9 h6 text-center text-success my-3">
                        <span>ミャンマー・ヤンゴンでお部屋探しならVRレジデンス へお任せください！</span>
                        <br>
                        <span>ミャンマーの住居では日本では考えられない色々なトラブルが発生しますが、</span><span>物件を仲介ではなく自社で管理しているからこそ可能なサービスで、</span><span>あなたのミャンマー生活を全力でサポートいたします。</span>
                    </div>
                </div>
            </div>
            <img src="{{ asset('customer/vrmyanmar/top.jpg') }}" class="img-cover" alt="">
        </div>

        <div id="section-2" class="row">
            <div class="container">
                <div class="col-12 pb-5">
                    <h2 class="font-weight-bold text-center text-success my-5">VRミャンマーが選ばれる11の理由</h2>
                    <p class="text-center mb-5">
                        弊社の管理物件は賃料に関わらず、以下のサービスが全て含まれております。<br>
                        そのため、初めてミャンマーに住む予定の方にも安心してご利用いただいております。
                    </p>
                </div>
            </div>
        </div>

        <div id="section-3" class="row mb-5">
            <div class="container d-grid x6 g-5 pb-5" style="grid-auto-rows: 1fr;">
                <div class="item g-col-1 invisible d-none d-md-block"></div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">24時間日本語電話サポート</h5>
                    <p>
                        <span>故障や緊急時に日本語でスタッフが対応するので安心です。</span>
                        <span>その他、生活相談など何でもお問い合わせください。</span>
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">家具・家電付き</h5>
                    <p>
                        アパートにはクイーンサイズベッド、TV、ソファ、冷蔵庫、洗濯機、クローゼットなどが付いているので、入居したその日から快適に暮らせます。
                    </p>
                </div>
                <div class="item g-col-1 invisible d-none d-md-block"></div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">停電対策（非常用電源装置の設置）</h5>
                    <p>
                        <span>急な停電に備えインバーターとバッテリーを設置してあります。</span>
                        <span>操作はとても簡単です。</span>
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">浄水器及び自動給水装置の設置</h5>
                    <p>
                        <span>浄水器を設置してあるので、ミャンマーでもきれいな水が使用可能です。</span>
                        <span>また、日本と同じように自動給水にすることでストレスなく利用できます。</span>
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">網戸設置</h5>
                    <p>
                        ミャンマーでは網戸を付ける文化はあまりありませんが、
                        弊社の取り扱う物件にはお部屋の換気及び蚊、ハエなどの虫対策として網戸を設置しております。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">シャワートイレ（ウォシュレット）の設置</h5>
                    <p>
                        ウォシュレットが設置されているところはミャンマーではほとんどありませんが、弊社の物件には全て設置済みです。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">インターネット接続</h5>
                    <p>
                        インターネット接続も家賃に含まれています。
                        そのため、インターネットの手続きをご自身でしていただく必要はありません。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">スカイネット（衛星放送）視聴可</h5>
                    <p>
                        NHKなどのニュース、映画、スポーツなどの様々なチャンネルが視聴できます。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">住民登録サポートサービス</h5>
                    <p>
                        ミャンマーの法律により、外国人は居住区を区役所に住民登録する必要があります。大変時間がかかる面倒な手続きを弊社が代行します。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">入居時にスターターキットをプレゼント（$50相当）</h5>
                    <p>
                        トイレットペーパー、ごみ袋、洗剤などの消耗品を入居時に1カ月分をプレゼントします。そのため、ご入居された日から不便なく過ごしていただけます。
                    </p>
                </div>
                <div class="item g-col-6 g-col-md-2">
                    <h5 class="font-weight-bold">水道光熱費支払い</h5>
                    <p>
                        面倒な支払いも弊社が代行いたします。
                    </p>
                </div>
            </div>
        </div>

        <div id="section-4" class="row">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center my-5">
                    <div class="col-12 col-md-6">
                        <h3>
                            <span>お部屋探しでお困りなら</span>
                            <span>お電話ください！</span>
                            <span>日本人スタッフが対応します。</span>
                        </h3>
                    </div>
                    <div class="col-12 col-md-6 mb-5">
                        <div class="row pb-4">
                            <div class="col-6">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <img src="{{ asset('customer/vrmyanmar/61.jpg') }}" class="img-cover" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <img src="{{ asset('customer/vrmyanmar/62.jpg') }}" class="img-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <blockquote>
                                <h5 class="text-center">
                                    <span>+95-9-263080652（日本から）</span><br>
                                    <span>09-263080652（ミャンマーから）</span><br>

                                    <strong>平日：9:00 〜 17:00, 土：9:00 - 13: 00（ミャンマー時間）</strong><br>
                                    ✉ alesvrm@vrmyanmar.net
                                </h5>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-5" class="row bg-grey py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="font-weight-bold text-center text-success my-5">VRミャンマーおすすめの物件紹介</h2>

                        <div class="card-deck text-sans">
                            <div class="card">
                                <div class="card-header bg-success text-white font-weight-bold">
                                    VR3-A
                                </div>
                                <div class="media-wrapper-4x3">
                                    <img src="{{ asset('customer/vrmyanmar/c1.jpg') }}" class="img-cover" alt="...">
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">桜、横綱ラーメン、50ｓｔバー、シティマート、オーシャンスーパーマーケット</li>
                                        <li class="list-group-item">ダウンタウン／空室あり</li>
                                        <li class="list-group-item"><i class="fas fa-dollar-sign"></i> 価格: 950 USD</li>
                                        <li class="list-group-item"><i class="fas fa-home"></i> 間取り専有面積: 2BR-60m2</li>
                                    </ul>
                                </div>

                                <div class="media-wrapper-3x2 border-top">
                                    <div class="p-3" style="overflow-y:scroll;">
                                        <span>1F : ご入居済</span><br><br>

                                        <span>2F：ご入居済</span><br><br>

                                        <span>2F：ご入居済</span><br><br>

                                        <span>2F：ご入居済</span><br><br>

                                        <span class="text-danger">4F：ご予約承り中</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="https://vrmyanmar.net/rent/vr3-a/" class="btn btn-sm btn-warning">詳細を見る</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-success text-white font-weight-bold">
                                    VR3-B
                                </div>
                                <div class="media-wrapper-4x3">
                                    <img src="{{ asset('customer/vrmyanmar/c2.jpg') }}" class="img-cover" alt="...">
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">B-Japan、横綱ラーメン、50ｓｔバー</li>
                                        <li class="list-group-item">ダウンタウン／空室あり</li>
                                        <li class="list-group-item"><i class="fas fa-dollar-sign"></i> 価格: 950 USD</li>
                                        <li class="list-group-item"><i class="fas fa-home"></i> 間取り専有面積: 2BR-60m2</li>
                                    </ul>
                                </div>

                                <div class="media-wrapper-3x2 border-top">
                                    <div class="p-3" style="overflow-y:scroll;">
                                        <span>1F：ご入居済</span><br><br>

                                        <span>1F：ご入居済</span><br><br>

                                        <span>1F：ご入居済</span><br><br>

                                        <span>1F：ご入居済</span><br><br>

                                        <span>2F：ご入居済</span><br><br>

                                        <span>2F：ご入居済</span><br><br>

                                        <span class="text-danger">2F：ご予約承り中</span><br><br>

                                        <span>4F：ご入居済</span><br><br>

                                        <span>4F：ご入居済</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="https://vrmyanmar.net/rent/vr3-a/" class="btn btn-sm btn-warning">詳細を見る</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-success text-white font-weight-bold">
                                    VR21
                                </div>
                                <div class="media-wrapper-4x3">
                                    <img src="{{ asset('customer/vrmyanmar/c3.jpg') }}" class="img-cover" alt="...">
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">ミャンマープラザ, みちのく,ジャパンショップ,ヤンキンセンター</li>
                                        <li class="list-group-item">ヤンキン／空室あり</li>
                                        <li class="list-group-item"><i class="fas fa-dollar-sign"></i> 価格: 2,200 USD ~ 2,900 USD</li>
                                        <li class="list-group-item"><i class="fas fa-home"></i> 間取り専有面積: 2BR-(115m2) & 3BR-(134m2)</li>
                                    </ul>
                                </div>

                                <div class="media-wrapper-3x2 border-top">
                                    <div class="p-3" style="overflow-y:scroll;">
                                        <span>5F : ご入居済</span><br><br>

                                        <span class="text-danger">14F：ご予約承り中</span><br><br>

                                        <span>16F：ご入居済</span><br><br>

                                        <span>17F：ご入居済</span><br><br>

                                        <span>17F：ご入居済</span><br><br>

                                        <span>19F：ご入居済</span><br><br>

                                        <span>19F：ご入居済</span><br><br>

                                        <span>20F：ご入居済</span><br><br>

                                        <span>21F：ご入居済</span><br><br>

                                        <span>22F：ご入居済</span><br><br>

                                        <span>23F：ご入居済</span><br><br>

                                        <span>25F：ご入居済</span><br><br>

                                        <span>25F：ご入居済</span><br><br>

                                        <span>26F：ご入居済</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="https://vrmyanmar.net/rent/vr3-a/" class="btn btn-sm btn-warning">詳細を見る</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-success text-white font-weight-bold">
                                    VR22
                                </div>
                                <div class="media-wrapper-4x3">
                                    <img src="{{ asset('customer/vrmyanmar/c4.jpg') }}" class="img-cover" alt="...">
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">ジャンクションスクエア,フジレストラン,PARKSON,喜洋洋,Bread Talk</li>
                                        <li class="list-group-item">サンチャウン／空室あり</li>
                                        <li class="list-group-item"><i class="fas fa-dollar-sign"></i> 価格: 3,000~ & 3,500 USD~D</li>
                                        <li class="list-group-item"><i class="fas fa-home"></i> 間取り専有面積: 2BR-(102m2) & 3BR-(130m2)</li>
                                    </ul>
                                </div>

                                <div class="media-wrapper-3x2 border-top">
                                    <div class="p-3" style="overflow-y:scroll;">
                                        <span>11F : ご入居済</span><br><br>

                                        <span>11F : ご入居済</span><br><br>

                                        <span class="text-danger">16F : ご入居済</span><br><br>

                                        <span>16F : ご予約済</span><br><br>

                                        <span>18F : ご入居済</span><br><br>

                                        <span class="text-danger">20F : ご予約承り中</span><br><br>

                                        <span>24F : ご入居済</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <a href="https://vrmyanmar.net/rent/vr3-a/" class="btn btn-sm btn-warning">詳細を見る</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-6" class="row">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center my-5">
                    <div class="col-12 col-md-6">
                        <h3>
                            <span>上記以外にもVRミャンマーでは</span>
                            <span>お部屋を豊富にご用意しております。</span>
                            <span>ミャンマーでお部屋探しならまずはお電話ください。</span>
                        </h3>
                    </div>
                    <div class="col-12 col-md-6 mb-5">
                        <div class="row pb-4">
                            <div class="col-6">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <img src="{{ asset('customer/vrmyanmar/61.jpg') }}" class="img-cover" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <img src="{{ asset('customer/vrmyanmar/62.jpg') }}" class="img-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <blockquote>
                                <h5 class="text-center">
                                    <span>+95-9-263080652（日本から）</span><br>
                                    <span>09-263080652（ミャンマーから）</span><br>

                                    <strong>平日：9:00 〜 17:00, 土：9:00 - 13: 00（ミャンマー時間）</strong><br>
                                    ✉ alesvrm@vrmyanmar.net
                                </h5>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-7" class="row">
            <div class="container mb-5">
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <img src="{{ asset('customer/vrmyanmar/feedback.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div id="section-8" class="row bg-grey pt-5">
            <div class="container mb-5 text-center">
                <div class="col-12 col-md-10 mx-auto">
                    <span class="h5 align-baseline text-left d-grid g-3" style="grid-template-columns: auto 1fr; font-size: 1.1rem;">

                        <span class="font-weight-bold text-right">住所：</span>
                        <span>Room 303, Office Tower, Novotel Yangon Max, 459 Pyay Road, Kamayut Township, Yangon. <span class="font-italic small">（Novotelホテル内にオフィスがございます）</span></span>



                        <span class="font-weight-bold text-right">電話：</span>
                        <span>
                            +95-9-263080652（日本から）<br>
                            09-263080652（ミャンマーから）
                        </span>



                        <span class="font-weight-bold text-right">営業時間：</span>
                        <span>
                            平日：9:00 〜 17:00（ミャンマー時間）<br>
                            土：9:00 - 13: 00（ミャンマー時間）
                        </span>

                    </span>
                </div>
            </div>
            <div class="col-12 p-0">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d61106.10343618096!2d96.1132818!3d16.819833!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb4aabd3fc11%3A0x415652183cd73011!2z44OO44Oc44OG44OrIOODpOODs-OCtOODsyDjg57jg4Pjgq_jgrk!5e0!3m2!1sja!2s!4v1554957651913!5m2!1sja!2s" frameborder="0" style="border:0; display: block; width: 100%; height: 50vh;" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
    var mySwiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        speed: 400,
        spaceBetween: 100,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        grabCursor: true,
        breakpoints: {
            576: {
                slidesPerView: 1.5,
                spaceBetween: 28
            },
        },
    });
    </script>
@endsection
