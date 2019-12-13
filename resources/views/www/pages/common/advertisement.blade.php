@extends('www.layouts.master')

@section('content')
<div id="grand-wrapper" class="container-fluid d-flex flex-column min-vh-100 bg-white p-0">
    <div id="about" class="container-fluid bg-white">
        <div id="hero-about" class="row">
            <div class="container position-relative">
                <p>
                    <span>ミャンマー最大級の</span><br/>
                    <span>メディア力を活用</span><br/>
                    <a href="{{ URL::to('/contact') }}" class="btn btn-lg btn-danger py-2 py-lg-3 shadow">お問い合わせ</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="container py-5">
                <h1 class="text-center pb-5" id="head-title">
                    <span>
                        <span>ミャンマー</span>
                        <span>在住日本人の</span>
                    </span>
                    <span>
                        8割がみる<span>生活情報</span>
                        <span>サイトで</span>
                    </span>
                    <span>
                        <span class="text-danger" style="font-weight: 800;">月$100から</span><span>広告掲載可能！</span>
                    </span>
                </h1>
                <div class="row border-bottom mb-3">
                    <div class="col-12 col-lg-7 mb-5"><a href="{{ URL::to('/') }}">
                        <img src="{{ asset('images/poste/advertisement/top-page.jpg')}}" class="img-fluid rounded shadow"></a>
                    </div>
                    <div class="col-12 col-lg-5 mb-5 d-flex flex-wrap justify-content-center align-items-center">
                        <div>
                            <h2 class="mb-3">POSTEとは何か</h2>
                            <p class="h5 mb-3">
                                POSTEは2013年にベトナム、2016年にカンボジアで誕生した日系生活情報コミュニティサイトです。2018年にミャンマーでもオープンし、ミャンマーの現地ニュースやカンボジアで生活するのに欠かせないで暮らしに役立つ情報を掲載掲載しています。 2019年現在、ヤンゴン在住日本人の約8割の方に毎月閲覧いただいています。
                            </p>
                            <a href="{{ URL::to('contact') }}" class="btn btn-danger badge-pill shadow">お問い合わせ</a>
                        </div>
                    </div>
                </div>
                <h2 class="text-center pt-3 mb-3">
                    POSTEで広告するメリット
                </h2>
                <div class="row mb-5">
                    <div class="col-12 col-lg-6">
                        <h2 class="mb-3">お店・サービスの紹介ページの作成</h2>
                        <p class="text-secondary">
                            <span>今では何でもインターネットで調べる時代。</span>
                            <span>利用者はお店の情報がインターネット上に無いと、</span>
                            <span>「このお店本当に大丈夫？」「閉店したの？」と</span>
                            <span>不安に思ってしまうこともしばしば。</span><br><br>
                            <span>でも、ホームページ作成会社に依頼すると</span>
                            <span>コストがかなりかかってしまいます。</span>
                            <span>メンテナンス代も侮れません。</span><br><br>

                            <span>そんな事態を解決するためにピッタリなのが、</span>
                            <span>POSTEでの紹介ページ作成です!!</span>
                            <span>お店の写真やメニューなど、必要な情報は全て入れることができます。</span>
                            <span>
                                もちろん、契約中の<span class="text-danger font-weight-bold">メンテナンス代は無料です。</span>
                            </span>
                        </p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <a href="{{ URL::to('/azumaya-massage') }}" class="d-block media-wrapper-16x9 rounded shadow mb-2" style="overflow-y: scroll;">
                            <img src="{{ asset('images/poste/advertisement/shoppage.jpg')}}" class="img-fluid">
                        </a>
                        <small class="d-block text-center">（例）東屋マッサージ様</small>
                    </div>
                </div>

                <div class="row mb-5 pb-5 border-bottom">
                    <div class="col-12">
                        <div class="about-tb p-3 pt-4 mb-5" title="成功事例〜東屋ホテル様〜">
                            <dl class="mt-2 mb-0">
                                <dt>お悩み</dt>
                                <dd>東屋ホテルに併設されているマッサージ店ということもあり、宿泊者からのマッサージ利用は多かったものの、マッサージに関する情報がHPにもほとんど無かったのでビジター利用の集客に苦戦していました。</dd>
                                <dt>解決策</dt>
                                <dd>紹介ページにマッサージの種類や料金、ホーチミン・ハノイ・ダナンの各店舗の営業時間など、利用者がお店に行く前に気になることを日本語で詳しく紹介しました。</dd>
                                <dt>結果</dt>
                                <dd>東屋マッサージのビジター利用に興味を持っていたお客さんにも情報が行き届くようになり、宿泊者以外のお客さんからの利用数がかなり大幅に伸びました。</dd>
                            </dl>
                        </div>
                        <h2 class="text-center mb-3">プロモーション情報アップ</h2>
                        <p class="mb-5 text-center text-secondary">
                            <span>ある調査によると、新しいお店に足を運ぶきっかけとなるのは、</span><span>友人や知人からの評判と口コミサイトのコメントだそうです。</span><span>しかし、その2つは時間をかけて蓄積されるもの。</span><span>いきなり得れるものではありません。</span><br><br>

                            そんな事態を解決してくれるのは、プロモーション情報です!!
                        </p>
                        <div class="about-tb p-3 pt-4 mb-5" title="成功事例〜ホーチミンのステーキ屋〜">
                            <dl class="mt-2 mb-0">
                                <dt>お悩み</dt>
                                <dd>多くのステーキレストランが軒を連ねるホーチミンの1区にお店を構えるステーキレストラン。昔は日本人客で毎晩賑わっていたものの、競合店の相次ぐ出店により客数が減少。味には自信があるものの、販促活動に苦戦していました。</dd>
                                <dt>解決策</dt>
                                <dd>認知度向上とリピート顧客獲得を目指し、期間限定で「4名以上のご来店でステーキ50％割引」を実施しました。</dd>
                                <dt>結果</dt>
                                <dd>11日間でプロモーション情報の閲覧者数は800名にのぼり、30名が実際に来店。リピート客に繋がる新規顧客獲得と認知度向上という目標を達成しました。</dd>
                            </dl>
                        </div>
                        <h2 class="mb-3 text-center">
                            SEO対策記事作成
                        </h2>
                        <p class="mb-5 text-center text-secondary">
                            <span>インターネットで情報をいくら発信したとしても、</span> <span>見てくれる人がいないと意味がありません。</span><br>
                            <span>POSTEでは⻑年のノウハウと知識を活かし、</span><span>SEO対策を行った記事を執 筆しています。</span><br><span>そのため、広告主の方のお店の情報が</span>記載されている 記事をGoogle検索上で上位に表示させることが可能です。
                        </p>
                    </div>
                    <div class="col-12 col-lg-6 mb-5">
                        <h5>ホーチミン ランチ</h5>
                        <span>検索Vol：100〜1000</span>
                        <div class="media-wrapper-4x3 border rounded">
                            <img src="{{ asset('images/about/hcm1.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-5">
                        <h5>ハノイ 日本食</h5>
                        <span>検索Vol：100〜1000</span>
                        <div class="media-wrapper-4x3 border rounded">
                            <img src="{{ asset('images/about/hn.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-5">
                        <h5>ホーチミン ステーキ</h5>
                        <span>検索Vol：100〜1000</span>
                        <div class="media-wrapper-4x3 border rounded">
                            <img src="{{ asset('images/about/hcm2.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-5">
                        <h5>ダナン　夜遊び</h5>
                        <span>検索Vol：100〜1000</span>
                        <div class="media-wrapper-4x3 border rounded">
                            <img src="{{ asset('images/about/dn.jpg') }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-wrap align-items-center">
                        <div class="col-12 col-lg-9 text-danger font-weight-bold"><span style="font-size: 1.8rem;">これらがセットになってになって、</span><span style="font-size: 1.8rem;">最安月$100から広告可能です!!</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-night" id="cv-form">
        <div class="container py-5">
            <h2 class="title text-center my-5"><span>お問い合わせは</span><span>こちら</span></h2>
            <form class="needs-validation mb-5 d-flex flex-wrap" action="{{ url('/contact') }}" novalidate action="#" method="POST" enctype="multipart/form-data">
                <div class="form-row col-12 p-0">
                    <div class="col-12 col-md mb-3">
                        <input type="text" class="form-control form-control-lg" name="txtName" id="txtName" value="" placeholder="氏名" required>
                        <div class="invalid-feedback">
                            <span>氏名が</span><span>正しく入力されているかご</span><span>確認ください。</span>
                        </div>
                    </div>
                    <div class="col-12 col-md mb-3">
                        <input type="email" class="form-control form-control-lg" name="txtContactEmail" id="txtContactEmail" value="" placeholder="メールアドレス" required>
                        <div class="invalid-feedback">
                            <span>メールアドレスが</span><span>正しく入力されているかご</span><span>確認ください。</span>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <textarea class="form-control" name="txtContent" id="txtContent" rows="3" required></textarea>
                        <div class="invalid-feedback">
                            <span>志望動機が</span><span>正しく入力されているかご</span><span>確認ください。</span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-lg mx-auto">問い合わせる</button>
            </form>
        </div>
    </div>
</div>
@endsection
