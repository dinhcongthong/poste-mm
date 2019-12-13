@extends('www.layouts.master')

@section('content')
<div class="container" id="fuji">
    <div class="bg-white mb-4">
        <div class="row">
            <div class="col-12 mb-4">
                <!-- Swiper -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide position-relative">
                            <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/top1.jpg') }}" alt="{{ $pageKeywords }}">
                            <div class="fixed-top w-100 h-100 position-absolute align-items-center top-image-caption">
                                <p class="pl-4">
                                    取り扱い件数最多、安心の日本語対応のFuji不動産でミャンマーの物件を探してみませんか？<br/>
                                    <span class="ml-2">・安心の日本語対応</span><br/>
                                    <span class="ml-2">・取り扱い物件数最多</span><br/>
                                    <span class="ml-2">・ローカルの不動産と同じ格安の紹介料設定</span><br/>
                                    <span class="ml-2">・面倒な契約手続きも日本語で安心サポート</span>

                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide position-relative">
                            <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/top2.jpg') }}" alt="{{ $pageKeywords }}">
                            <div class="fixed-top w-100 h-100 position-absolute align-items-center top-image-caption">
                                <p class="pl-4">
                                    Fuji不動産では物件販売、賃貸、土地販売、工業用地を取り扱っています。<br/>
                                    <span class="ml-2">・駐在員向け高級サービスアパート</span><br/>
                                    <span class="ml-2">・格安ローカルアパート</span><br/>
                                    <span class="ml-2">・事業用の土地販売</span><br/>
                                    <span class="ml-2">・新工場建設におすすめの工業用地 ...etc</span>

                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="border border-dark rounded text-center mx-4 p-3">
                    <h2 class="text-primary font-weight-bold mt-0">Fuji不動産</h2>
                    <p>
                        ミャンマーで外国人が不動産を借りる場合には規制が厳しく、不便に感じることも多いはず。不動産選びや手続きが難しいミャンマーで、Fuji不動産はスタッフが物件探しから、契約手続き、アフタフォローまで全て日本語で安心サポートします。格安・高級物件や商業・工業用物件まで取り揃えているため、様々な要望に対応します。ミャンマー最多の取り扱い件数の中からあなたの要望や予算にあった最適な物件をご提案します。
                    </p>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="border border-dark rounded mx-4 p-3">
                    <h2 class="text-primary font-weight-bold mt-0">Fuji不動産、紹介可能案件</h2>

                    <div class="step-item border-bottom pb-2">
                        <div class="row">
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold">販売物件</h3>
                                    <p>
                                        Fuji不動産ではマンションから一戸建てまで中古・新築問わず幅広く紹介可能です。物件検索では「価格」「面積」「間取」「住所」「築年月」で選んで物件を検索することが出来るので、お客様のミャンマーでのライフスタイルに合わせた物件を探すことができます。また、お問い合わせにより、日本語対応可能なスタッフがお客様の要望にぴったりな物件を紹介します。
                                    </p>
                                    <p>
                                        <a href="http://fujirealestate.asia/?bukken=house_for_sale&shu=&mid=999&nor=999&paged=&so=kak&ord=&s=" target="_blank">▶︎販売物件の詳細情報はこちら</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/c3.png') }}" alt="{{ $pageKeywords }}">
                            </div>
                        </div>
                    </div>
                    <div class="step-item border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold">貸物件</h3>
                                    <p>
                                        ダウンタウン地区やバハン地区など、ヤンゴン全地域で300件以上の賃貸物件を紹介可能です。「オフィスの近く」、「日本食店が多くある地域」などお客様の要望に沿ったおすすめ物件を提案します。駐在や留学、インターンシップなど、一定期間でミャンマーに在住する人には賃貸物件がおすすめ。
                                    </p>
                                    <p>
                                        <a href="http://fujirealestate.asia/?bukken=house_for_rent" target="_blank">▶︎賃貸物件の詳細情報はこちら</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/c5.png') }}" alt="{{ $pageKeywords }}">
                            </div>
                        </div>
                    </div>
                    <div class="step-item border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold">土地販売</h3>
                                    <p>
                                        ミャンマーでの事業開始に向け土地を探しているという人にもFuji不動産がおすすめ。ミャンマーの事情に精通し、日本語対応可能なスタッフが最適な土地を提案します。土地の所有におけるトラブルが頻発するミャンマーで購入を検討している場合、まずはFuji不動産にご相談を。
                                    </p>
                                    <p>
                                        <a href="hhttp://fujirealestate.asia/?bukken=land" target="_blank">▶︎土地販売の詳細情報はこちら</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/c7.jpg') }}" alt="{{ $pageKeywords }}">
                            </div>
                        </div>
                    </div>
                    <div class="step-item pt-2">
                        <div class="row">
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold">工業用地</h3>
                                    <p>
                                        ティラワ経済特別区をはじめ、ミャンマーには日系企業の工場が相次いで設立されています。「新しくミャンマーに工場を設立したいけど、ミャンマーの事情についてよく分からない」といったお悩みを持った個人・法人の方は是非、Fuji不動産にご相談を。経験豊富なスタッフがお客様の要望に沿った工業用地をお探しします。
                                    </p>
                                    <p>
                                        <a href="http://fujirealestate.asia/?page_id=91" target="_blank">▶︎工業用地の詳細情報はこちら</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid" src="{{ asset('customer/fuji_real_estate/c9.jpg') }}" alt="{{ $pageKeywords }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="border border-dark rounded mx-4 p-3 text-center">
                    <a href="http://fujirealestate.asia/" target="_blank" class="btn btn-primary">物件情報の詳細はこちらから</a>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="border border-dark rounded mx-4 p-3">
                    <h2 class="text-primary font-weight-bold mt-0 text-center">Fuji不動産が選ばれる理由</h2>

                    <div class="step-item border-bottom pb-2">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid mb-2" src="{{ asset('customer/fuji_real_estate/e3.jpg') }}" alt="{{ $pageKeywords }}">
                            </div>
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold text-primary">日本語対応可能なスタッフによる仲介がローカルの不動産と同程度の紹介料で可能</h3>
                                    <p class="mb-0">
                                        Fuji不動産ではローカルと同じ紹介料設定で、日本語対応可能なスタッフによるサポートが受けられます。電気や水道の手続き、契約に関することなど煩雑な作業を行わなくてはなりません。ローカルの料金設定で、日本語対応可能なため、Fuji不動産は選ばれ続けています。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-item border-bottom py-2">
                        <div class="row">
                            <div class="col-12 col-lg-5 order-lg-2">
                                <img class="img-fluid mb-2" src="{{ asset('customer/fuji_real_estate/e5.jpg') }}" alt="{{ $pageKeywords }}">
                            </div>
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold text-primary">ミャンマーの事情に精通したスタッフによる対応</h3>
                                    <p class="mb-0">
                                        ヤンゴンでの新生活には、交通事情や医療、教育知っておくべき情報が数多くあります。初めてのヤンゴン生活でも快適な生活ができるよう、Fuji不動産ではミャンマーの事情に精通したスタッフが丁寧に対応し、お客様にあった提案をします。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-item pt-2">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <img class="img-fluid mb-2" src="{{ asset('customer/fuji_real_estate/e7.jpg') }}" alt="{{ $pageKeywords }}">
                            </div>
                            <div class="col-12 col-lg-7 d-flex align-items-center">
                                <div>
                                    <h3 class="font-weight-bold text-primary">ミャンマーで最多の紹介物件数</h3>
                                    <p class="mb-0">
                                        高級サービスアパート、格安物件、家族向け物件など要望は様々。Fuji不動産では様々な種類の紹介物件を保有しているため、お客様にあった物件をご提案します。まずはお気軽に日本語でお問い合わせください。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="border border-dark rounded mx-4 p-3 text-center">
                    <a href="http://fujirealestate.asia/?page_id=68" target="_blank" class="btn btn-primary">
                        お問い合わせはこちらから<br/>
                        （インターネットにて24時間受付中）
                    </a>
                </div>
            </div>
            <div class="col-12 mb-4 text-center">
                <span class="text-primary font-weight-bold info-title">会社概要</span><br/>
                <span class="sub-info-title">日本語でお気軽にお問い合わせください</span>
            </div>

            <div class="col-12">
                <div class="px-3 d-flex justify-content-center bg-primary">
                    <div>
                        <h2 class="text-white text-center pb-4 font-weight-bold">Fuji Real Estate</h2>
                        <p class="text-white d-flex info-p justify-content-center">
                            <span class="font-weight-bold mr-md-2">住所：</span>
                            <span>
                                （ヤンゴン本店）205, Yuzana Tower 3F, Shwe Gone Daing, Bahan Township,Yangon<br/>
                                （タンリン支店）Kyeik Khout Pagoda Road, Aung Chan Thar(3) Ward, Than Lyin, Yangon
                            </span>
                        </p>
                        <p class="text-white d-flex info-p justify-content-center">
                            <span class="font-weight-bold mr-md-2">電話番号：</span>
                            <span>
                                （ヤンゴン本店）+95(0)9-453067351 ・ +95(0)9-453067352 <br/>
                                （タンリン支店）+95(0)9-421111731 ・ +95(0)9-31357468<br/>
                                <strong>※日本語対応可能</strong>
                            </span>
                        </p>
                        <p class="text-white d-flex info-p justify-content-center">
                            <span class="font-weight-bold mr-md-2">メールアドレス：</span>
                            <span>
                                <a class="text-white text-decoration-underline" href="mailto:fujirealestate1@gmail.com" target="_blank">fujirealestate1@gmail.com</a>（本間）
                            </span>
                        </p>
                        <p class="text-white d-flex justify-content-center">
                            <span class="font-weight-bold mr-3">HP:</span>
                            <span>
                                <a class="text-white" href="http://fujirealestate.asia/" target="_blank">http://fujirealestate.asia/</a>
                            </span>
                        </p>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.405044217136!2d96.15241541486834!3d16.806250488429335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eca7afd2c4a3%3A0x2a2e8130ee49af6e!2zWXV6YW5hIFRvd2VyLCBLYWJhciBBeWUgUGFnb2RhIFJkLCBZYW5nb24sIOODn-ODo-ODs-ODnuODvA!5e0!3m2!1sja!2s!4v1550732403636" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var swiper = new Swiper('.swiper-container', {

        loop: true,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination'
        },
    });
</script>
@endsection
