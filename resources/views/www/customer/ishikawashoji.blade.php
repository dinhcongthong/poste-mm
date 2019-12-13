@extends('www.layouts.master')

@section('content')
    <div class="container-fluid" id="grand-wrapper">
        <div class="row bg-top">
            <div class="container d-flex mt-3 align-items-start justify-content-center">
                <img src="{{ asset('customer/ishikawashoji/logo-Ishikawa-GreenWhite.png') }}" alt="{{ $pageKeywords }}" class="img-fluid">
            </div>
        </div>
        <div class="row bg-white">
            <div class="container">
                <div id="section-a" class="col-12 p-3 bg-re mt-n5">
                    <h2 class="title text-center mt-0 mb-3">ミャンマーでのお部屋探しでこんなお悩みはありませんか？</h2>
                    <div class="d-grid x1 x3-md g-3 text-re">
                        <div class="bg-white px-3 py-2">ミャンマーに行ったことが無く、土地勘が無いからどこのお部屋を借りていいのか分からない。</div>
                        <div class="bg-white px-3 py-2">年間契約・1活払いが基本のミャンマー。大家さんに交渉がしたいけれど、ミャンマー語が話せない。</div>
                        <div class="bg-white px-3 py-2">インターネットで探しているのに、ミャンマーで欲しい物件がなかなか見つからない。</div>
                    </div>
                </div>
                <div id="section-b" class="col-12 p-3 p-md-5">
                    <p class="text-center text-re mt-0 mb-3 h5">
                        お部屋探しをしている方はとりあえず相談してください。<br>
                        あなたにピッタリの物件が見つかるまで諦めません!!
                    </p>
                </div>
            </div>
            <div id="section-c" class="col-12 p-0 py-5 bg-re">
                <div class="container text-center p-3">
                    <h2 class="title text-center text-white mt-0 mb-3">石川商事の物件情報</h2>
                    <div class="d-grid x2 x3-md xr3 xr2-md g-3 text-re">
                        <a href="https://poste-mm.com/dailyinfo/ishikawashoji-357" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190317-1552800194.0317.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">サービスアパート</div>
                            </div>
                        </a>
                        <a href="https://poste-mm.com/dailyinfo/ishikawashoji-358" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190317-1552808726.4964.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">コンドミニアム</div>
                            </div>
                        </a>
                        <a href="https://poste-mm.com/dailyinfo/ishikawa-382" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190327-1553664390.1448.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">
                                    地方物件<br>（ネピドー・マンダレーなど）
                                </div>
                            </div>
                        </a>
                        <a href="https://poste-mm.com/dailyinfo/20190327-385" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190327-1553668613.8775.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">一戸建て</div>
                            </div>
                        </a>
                        <a href="https://poste-mm.com/dailyinfo/ishikawa-387" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190327-1553672431.8487.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">土地</div>
                            </div>
                        </a>
                        <a href="https://poste-mm.com/dailyinfo/ishikawa-386" class="nav-link p-0">
                            <div class="media-wrapper-1x1 rounded-circle">
                                <img src="https://poste-mm.com/upload/news/news_20190327-1553670990.269.jpg" class="img-cover" alt="">
                                <div class="d-flex align-items-center justify-content-center h4 m-0">商業用施設・オフィスビル</div>
                            </div>
                        </a>
                    </div>
                    <a href="http://ishikawashoji.com/mm/contact-us/" target="_blank" class="btn btn-success btn-lg btn-re mt-5">まずは相談してみる</a>
                </div>
            </div>
            <div id="section-d" class="col-12 p-0 py-5">
                <div class="container text-center p-3">
                    <h2 class="title text-center mt-0 mb-3">石川商事からお知らせ</h2>
                    <div class="d-grid x1 x4-md g-3 text-re text-left">
                        <a href="#" class="nav-link p-0 bg-white position-relative">
                        </a>
                        <a href="https://poste-mm.com/lifetip/area-information-356" class="nav-link p-0 bg-white position-relative">
                            <div class="media-wrapper-1x1">
                                <img src="https://poste-mm.com/upload/news/news_20190316-1552740316.6832.jpg" class="img-cover" alt="">
                            </div>
                            <div class="h6">ヤンゴンのエリア別マップ｜ショッピングモールやレストランが多いおすすめの地域も紹介</div>
                        </a>
                        <a href="https://poste-mm.com/lifetip/myanmar-life-355" class="nav-link p-0 bg-white position-relative">
                            <div class="media-wrapper-1x1">
                                <img src="https://poste-mm.com/upload/news/news_20190316-1552729862.5332.jpg" class="img-cover" alt="">
                            </div>
                            <div class="h6">ミャンマー・ヤンゴンでの生活事情｜生活費・買い物場所・基礎知識などまとめて紹介</div>
                        </a>
                    </div>
                    <a href="http://ishikawashoji.com/mm/contact-us/" target="_blank" class="btn btn-success btn-lg btn-re mt-5">まずは相談してみる</a>
                </div>
            </div>
            <div id="section-e" class="col-12 p-0 py-5 bg-light border-top border-bottom">
                <div class="container text-center p-3">
                    <h2 class="title text-center text-re mt-0 mb-3">ご入居までの流れ</h2>
                    <div class="col col-md-6 mx-auto d-grid x1 g-3">
                        <div class="re-step">
                            <h5 class="text-center p-3 m-0 w-100">石川商事にご相談</h5>
                        </div>
                        <div class="re-step">
                            <h5 class="text-center p-3 m-0 w-100">物件の下見</h5>
                        </div>
                        <div class="re-step">
                            <h5 class="text-center p-3 m-0 w-100">物件のご予約</h5>
                        </div>
                        <div class="re-step">
                            <h5 class="text-center p-3 m-0 w-100">契約手続き</h5>
                        </div>
                        <div class="re-step">
                            <h5 class="text-center p-3 m-0 w-100">物件の引き渡し</h5>
                        </div>
                    </div>
                    <a href="http://ishikawashoji.com/mm/contact-us/" target="_blank" class="btn btn-success btn-lg btn-re mt-5">まずは相談してみる</a>
                </div>
            </div>
            <div id="section-f" class="col-12 p-0 py-5">
                <div class="container text-center p-3">
                    <h2 class="title text-center mt-0 mb-3">お客様の声</h2>
                    <div class="swiper-container text-re">
                        <div class="swiper-wrapper">
                            <a href="#" class="swiper-slide nav-link p-0 bg-white">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <div class="no-image"></div>
                                </div>
                                <div class="py-3 m-0 h5">女性/主婦/46歳</div>
                                <p class="feed-back">
                                    お部屋探しの時から女性目線で考えていただけたので、とても安心することができました。<br>
                                    キッチンの高さなど、女性にしか分からない細やかな点も気づいていださったことに感謝しています。<br>
                                    また、入居後にも、電子レンジのオーブントースターの設置台の場所やシーツのリネンの準備など、細かいサポートと気遣いをしていただきました。ミャンマーの知識が無い私達に代わって、親身になって子供の学校やスーパーまでの近さも物件探しの際に考慮してくださたので、安心して入居することができました。
                                </p>
                            </a>
                            <a href="#" class="swiper-slide nav-link p-0 bg-white">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <div class="no-image"></div>
                                </div>
                                <div class="py-3 m-0 h5">男性/単身/25歳</div>
                                <p class="feed-back">
                                    会社の予算が低いため、ローカルのコンドミニアムを探していて、石川商事に相談してみました。安い予算にも関わらず、20件も比較していただいて、とてもためになりましたし、非常に良い物件を見つけることができて満足しています。以前住んでいた部屋からの引っ越しのサポートまでしていただき、とてもスムーズに引っ越しをすることができました。
                                </p>
                            </a>
                            <a href="#" class="swiper-slide nav-link p-0 bg-white">
                                <div class="media-wrapper-1x1 rounded-circle">
                                    <div class="no-image"></div>
                                </div>
                                <div class="py-3 m-0 h5">男性/駐在/51歳</div>
                                <p class="feed-back">
                                    いろいろなオフィスを見学させていただきましたが、石川商事さんで契約を決めました。内装工事が必要だったのですが、内装準備までお手伝いいただき、スムーズに期日までにオフィスをオープンすることができました。管理事務所のスローな対応だったので、期日を越えてしまいそうでしたが、石川商事さんのおかげで大丈夫でした!!
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            <div id="section-g" class="col-12 p-0 py-5 d-flex flex-column bg-dark vh-100">
                <h2 class="title text-center text-white mt-0 mb-3">よくある質問</h2>
                <ol id="accordionExample" class="container flex-grow-1 text-success h4 d-grid x1 g-3" style="overflow-y: scroll;">
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question1" aria-expanded="true" aria-controls="question1">
                            <span>年契約が基本のミャンマーですが、半年契約は可能ですか?</span>
                        </a>
                        <div id="question1" class="collapse show">
                            <div class="re-a">
                                <span>コンドミニアムは1年払いが風習ですが、半年払いも最近は可能になってきました。サービスアパートメントの場合、月あたりの支払いも交渉は可能ですが、1ヶ月あたりの賃料が高くなってしまいます。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question2" aria-expanded="true" aria-controls="question2">
                            <span>日本からの電化製品は持っていってもいいですか？</span>
                        </a>
                        <div id="question2" class="collapse show">
                            <div class="re-a">
                                <span>電圧が違うので、止めておくことをおすすめします。また、最近ではミャンマーでも比較的良質な電化製品が揃っているのでご安心ください。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question3" aria-expanded="true" aria-controls="question3">
                            <span>契約後のフォローアップはどうしていますか？</span>
                        </a>
                        <div id="question3" class="collapse show">
                            <div class="re-a">
                                <span>ミャンマーは雨季が長いため、お部屋のメンテナンスが必要になることが多いので、定期的にメンテナンスをしております。配線や水回りのメンテナンス、エアコンの清掃などを半年に1回行ってもらうようにしています。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question4" aria-expanded="true" aria-controls="question4">
                            <span>物件選びの際の注意点を教えてください。</span>
                        </a>
                        <div id="question4" class="collapse show">
                            <div class="re-a">
                                <span>ミャンマーは雨季が長いため、水没エリアではないか確認することが大切です。石川商事にご連絡いただいた場合、全て丁寧にお教えします。また、手頃な価格のサービスアパートに住む方は、水回りの設備に注意が必要です。例えば、手頃な価格のアパートですと、日本と違って下水のパイプが上下に曲がっていないものが多く、下水の水が上がってきて臭くなってしまうなどの事態になってしまう恐れがあります。また、日本人は日の当たる部屋を好む傾向がありますが、ミャンマーは日差しが強いため、日が当たらない部屋の方が涼しく快適に過ごすことができます。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question5" aria-expanded="true" aria-controls="question5">
                            <span>ミャンマーで物件の契約をする際に知っておくべきこと・気をつけておくべきことを教えてください。</span>
                        </a>
                        <div id="question5" class="collapse show">
                            <div class="re-a">
                                <span>基本的にミャンマーの物件は、1年契約・前払いです。サービスアパートメントですと、大家さんにもよりますが、半年払いなどの交渉も可能です。また、サービスアパート以外ですと、入居後部屋の破損などの対応は個人負担の場合が多いので、契約前の確認をおすすめします。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question6" aria-expanded="true" aria-controls="question6">
                            <span>下見はいつ頃にするのがベストですか？</span>
                        </a>
                        <div id="question6" class="collapse show">
                            <div class="re-a">
                                <span>物件の雰囲気を知りたい場合、ご入居の半年前くらいが良いですが、無くなってしまう可能性もあります。ですので、本格的にご入居を決められる際は2ヶ月前ぐらいがベストです!! ただし、3・4月は込みあいますのでお早めにご相談ください！</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question7" aria-expanded="true" aria-controls="question7">
                            <span>ミャンマーは停電が多いと聞いたのですが本当ですか？</span>
                        </a>
                        <div id="question7" class="collapse show">
                            <div class="re-a">
                                <span>以前よりかはだいぶ減りましたが、日本と比べて停電が多いのは事実です。サービスアパートメントは基本的に発電機がついているので問題ないですが、その他の物件に関しては、発電機が付いているかを事前に確かめてからご入居されることをおすすめします。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question8" aria-expanded="true" aria-controls="question8">
                            <span>日本語のTVは見れますか?? また、Wifiをつなぐのはいくらぐらいですか??</span>
                        </a>
                        <div id="question8" class="collapse show">
                            <div class="re-a">
                                <span>SK YNETでNHKを見ることができます。また、インターネットは、月3000円くらいの契約で使い放題が可能です。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question9" aria-expanded="true" aria-controls="question9">
                            <span>ミャンマーの水は汚いってきいたんですけど本当ですか？</span>
                        </a>
                        <div id="question9" class="collapse show">
                            <div class="re-a">
                                <span>コンドミニアムに浄水施設も併設されており、改善傾向にはありますが、日本と比べると汚いのが現状です。石川商事ではローカルアパートの場合、浄水器の設置のフォローアップも行っております。</span>
                            </div>
                        </div>
                    </li>
                    <li class="col-12 p-3">
                        <a class="nav-link text-light re-q" data-toggle="collapse" href="#question10" aria-expanded="true" aria-controls="question10">
                            <span>オフィス物件を借りる場合はどのような手順ですか？</span>
                        </a>
                        <div id="question10" class="collapse show">
                            <div class="re-a">
                                <span>物件探しだけでなく、内装工事、インターネット開通のお手伝いなど、全てフォローアップもさせていただきます。</span>
                            </div>
                        </div>
                    </li>
                </ol>
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
