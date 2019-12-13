@extends('www.layouts.master')

@section('sticky-menu')
<div class="px-1 bg-danger text-center text-white py-4 font-weight-bold" style="font-size: 29px;">
    只今オープン準備中です
</div>
@endsection

@section('content')
<div class="container-fluid bg-white">
    <div class="row mb-5">
        <div class="container pt-3">
            <div class="d-flex flex-wrap mb-3 border border-secondary rounded">
                <div class="col-12 col-lg-4 d-flex">
                    <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/logo-az-dark.png') }}" class="img-fluid m-auto mb-3">
                </div>
                <div class="col p-3 basic-info">
                    <h3>東屋マッサージ</h3>
                    <dl class="row mb-3">
                        <dt class="col-12 col-lg-4 text-left text-lg-right">住所：</dt>
                        <dd class="col-12 col-lg-8">
                            <a href="https://goo.gl/maps/Hz6eMYKNPhvruv2YA"> No. No.55, Old Yay Tar Shay Road, Near Bahan 3th Street Market, Bahan Township, Yangon</a>
                        </dd>
                        <dt class="col-12 col-lg-4 text-left text-lg-right">受付ホットライン：</dt>
                        <dd class="col-12 col-lg-8">01 543 436</dd>
                        <dt class="col-12 col-lg-4 text-left text-lg-right">メール：</dt>
                        <dd class="col-12 col-lg-8">
                            <a href="mailto:reservation@azumayamyanmar.com"> reservation@azumayamyanmar.com</a>
                        </dd>
                        <dt class="col-12 col-lg-4 text-left text-lg-right">Website：</dt>
                        <dd class="col-12 col-lg-8"><a href="http://azumayamyanmar.com/">http://azumayamyanmar.com/</a></dd>
                    </dl>
                </div>
            </div>
            <div id="top-slider">
                <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/main.jpg') }}" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="container">
            <div class="row d-none d-lg-flex mb-5 align-items-center flex-wrap">
                <div class="col-12 col-md-6">
                    <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/about.jpg') }}" class="img-fluid" style="border-radius: .5rem; overflow: hidden; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important; margin: auto;">
                </div>
                <div class="col-12 col-md-6">
                    <h3 class="about-title">About Azumaya Massage</h3>
                    <p>
                        「和のおもてなし」をコンセプトにした東屋ホテル内に併設された東屋マッサージでは、リピート率90%以上の人気のフットマッサージをお受けいただけます。<br>

                        フットマッサージとは言ってもリクライニングシートで頭から背中まで全身をくまなく施術します。<br>
                        ただ気持ちいいだけのマッサージではなく、終えた後に体が楽になる痛気持ちいい本格マッサージです。<br>
                        施術はすべて中国マスターにより指導を受けたスタッフが対応させていただきます。もちろん、ビジター利用も可能です。<br>

                        マッサージ中は女性スタッフが「痛くないですか??」「気持ちいいですか??」と日本語で聞いてくれるため、程よい気持ち良さのマッサージを受けることができます。<br>

                        おすすめのマッサージコースは露天風呂とマッサージのセットです。仕事や家事、育児と疲れ切った身体の疲れを芯からほぐしてくれます。<br>

                        <span class="small">※露天風呂の利用可能時間は女性と男性で異なります。詳しくは店舗情報をご覧ください。</span>
                    </p>
                </div>
            </div>
            <div id="about-mobile" class="col-12 d-block d-lg-none">
                <div>
                    <h3 class="about-title">About Azumaya Massage</h3>
                    <p>
                        「和のおもてなし」をコンセプトにした東屋ホテル内に併設された東屋マッサージでは、リピート率90%以上の人気のフットマッサージをお受けいただけます。<br>

                        フットマッサージとは言ってもリクライニングシートで頭から背中まで全身をくまなく施術します。<br>
                        ただ気持ちいいだけのマッサージではなく、終えた後に体が楽になる痛気持ちいい本格マッサージです。<br>
                        施術はすべて中国マスターにより指導を受けたスタッフが対応させていただきます。もちろん、ビジター利用も可能です。<br>

                        マッサージ中は女性スタッフが「痛くないですか??」「気持ちいいですか??」と日本語で聞いてくれるため、程よい気持ち良さのマッサージを受けることができます。<br>

                        おすすめのマッサージコースは露天風呂とマッサージのセットです。仕事や家事、育児と疲れ切った身体の疲れを芯からほぐしてくれます。<br>

                        <span class="small">※露天風呂の利用可能時間は女性と男性で異なります。詳しくは店舗情報をご覧ください。</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <h3 id="gallery">ご利用方法</h3>
        <div class="container">
            <div id="step">
                <div class="col-6 col-md-3 px-3 px-md-5 mb-3">
                    <div class="img-1x1 mb-4">
                        <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/step1.jpg') }}" class="img-fluid">
                    </div>
                    <h3 style="font-size: 20px; color: #007bff; text-align: center; font-weight: 700;">Step-1<br>来店</h3>
                    <p class="text-center">プノンペンタワーの目の前にある、東屋ホテルプノンペン店にご来店ください。</p>
                </div>
                <div class="col-6 col-md-3 px-3 px-md-5 mb-3">
                    <div class="img-1x1 mb-4">
                        <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/step2.jpg') }}" class="img-fluid">
                    </div>
                    <h3 style="font-size: 20px; color: #28a745; text-align: center; font-weight: 700;">Step-2<br>チケット購入</h3>
                    <p class="text-center">ホテルの受付で希望のコースのチケットをご購入ください。受付スタッフは日本語対応が可能です。分からないことがあれば、お気軽にご相談ください。</p>
                </div>
                <div class="col-6 col-md-3 px-3 px-md-5 mb-3">
                    <div class="img-1x1 mb-4">
                        <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/step3.jpg') }}" class="img-fluid">
                    </div>
                    <h3 style="font-size: 20px; color: #ffc107; text-align: center; font-weight: 700;">Step-3<br>お着替え</h3>
                    <p class="text-center">東屋マッサージではマッサージの施術衣をご用意させていただいております。お好きな格好でご来店ください。</p>
                </div>
                <div class="col-6 col-md-3 px-3 px-md-5 mb-3">
                    <div class="img-1x1 mb-4">
                        <img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/step4.jpg') }}" class="img-fluid">
                    </div>
                    <h3 style="font-size: 20px; color: #6f42c1; text-align: center; font-weight: 700;">Step-3<br>マッサージ開始</h3>
                    <p class="text-center">リクライニングシートでゆったりとした時間をお楽しみください。</p>
                </div>
            </div>

            <div class="row mb-5">
                <h3 id="gallery">マッサージメニュー</h3>
                <div class="container">
                    <div>
                        <div id="menu">
                            <div class="menu-item">
                                <div class="mh">
                                    <span class="badge badge-primary">露天風呂 + サウナ</span>
                                    <div class="small mt-5 font-weight-normal">※露天風呂の利用可能時間は女性と男性で異なります。詳しくは店舗情報をご覧ください。</div>
                                </div>
                                <div class="mp">設定中</div>
                            </div>
                            <div class="menu-item">
                                <div class="mh">
                                    <span class="badge badge-success">足湯</span> ＋ <span class="d-inline-block d-lg-none badge badge-success">脚全体</span> <span class="d-none d-lg-inline-block"><span class="badge badge-success">ひざ下</span> ＋ <span class="badge badge-success">ふくらはぎ</span>  ＋ <span class="badge badge-success">足裏</span>＋ <span class="badge badge-success">太もも</span></span>
                                </div>
                                <div class="mt">40分コース</div>
                                <div class="mp">設定中</div>
                            </div>
                            <div class="menu-item">
                                <div class="mh">
                                    <span class="badge badge-success">足湯</span> ＋
                                    <span class="badge badge-danger ">顔</span> ＋
                                    <span class="badge badge-danger">腕</span> ＋
                                    <span class="d-none d-lg-inline-block">
                                        <span class="badge badge-success ">ひざ下</span> ＋
                                        <span class="badge badge-success ">ふくらはぎ</span> ＋
                                        <span class="badge badge-success ">足裏</span> ＋
                                        <span class="badge badge-success ">太もも </span>
                                    </span>
                                    <span class="badge badge-success d-inline-block d-lg-none">脚全体 </span>  ＋
                                    <span class="badge badge-danger">背中・肩</span><br>
                                    <div class="small" style="font-weight: 400;">（＋＄4で露天風呂とサウナも利用可能です）</div>
                                </div>
                                <div class="mt">70分コース</div>
                                <div class="mp">設定中</div>
                            </div>
                            <div class="menu-item">
                                <div class="mh">
                                    <span class="badge badge-success">足湯</span> ＋
                                    <span class="badge badge-danger ">顔</span> ＋
                                    <span class="badge badge-danger">腕</span> ＋
                                    <span class="d-none d-lg-inline-block">
                                        <span class="badge badge-success ">ひざ下  </span> ＋
                                        <span class="badge badge-success ">ふくらはぎ  </span> ＋
                                        <span class="badge badge-success ">足裏  </span> ＋
                                        <span class="badge badge-success ">太もも  </span>
                                    </span>
                                    <span class="badge badge-success d-inline-block d-lg-none">脚全体 </span> ＋
                                    <span class="badge badge-danger">背中・肩</span><br>
                                    <div class="small " style="font-weight: 400;">（＋＄4で露天風呂とサウナも利用可能です）</div>
                                </div>
                                <div class="mt">100分コース</div>
                                <div class="mp">設定中</div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row mb-5">
                <h3 id="gallery">店内イメージ</h3>
                <div class="container">
                    <div class="d-flex flex-wrap gallery">
                        <div class="col-12 col-sm-6 col-md"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/2.jpg') }}" class="img-fluid"></div>
                        <div class="col-xs-6 col-sm-6 col-md"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/1.jpg') }}" class="img-fluid"></div>
                        <div class="col-xs-6 col-sm-4 col-md"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/3.jpg') }}" class="img-fluid"></div>
                        <div class="col-xs-6 col-sm-4 col-md"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/4.jpg') }}" class="img-fluid"></div>
                        <div class="col-xs-6 col-sm-4 col-md"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/5.jpg') }}" class="img-fluid"></div>
                    </div>
                    <div class="mt-3 text-center gallery-text w-100 font-weight-normal">写真はイメージです。実際とは異なる場合があります。</div>
                </div>
            </div>
            <div class="row">
                <div class="container d-flex flex-wrap">
                    <div id="info" class="col-12 col-md-6 basic-info">
                        <h3>店舗情報</h3>
                        <dl class="row mb-3">
                            <dt class="col-12 col-lg-4 text-left text-lg-right">住所：</dt>
                            <dd class="col-12 col-lg-8">
                                <a href="https://goo.gl/maps/Hz6eMYKNPhvruv2YA"> No. No.55, Old Yay Tar Shay Road, Near Bahan 3th Street Market, Bahan Township, Yangon</a>
                            </dd>
                            <dt class="col-12 col-lg-4 text-left text-lg-right">受付ホットライン：</dt>
                            <dd class="col-12 col-lg-8">01 543 436</dd>
                            <dt class="col-12 col-lg-4 text-left text-lg-right">メール：</dt>
                            <dd class="col-12 col-lg-8">
                                <a href="mailto:reservation@azumayamyanmar.com"> reservation@azumayamyanmar.com</a>
                            </dd>
                            <dt class="col-12 col-lg-4 text-left text-lg-right">Website：</dt>
                            <dd class="col-12 col-lg-8"><a href="http://azumayamyanmar.com/">http://azumayamyanmar.com/</a></dd>
                        </dl>
                    </div>
                    <div class="col-12 col-md-6 p-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3819.5302256148984!2d96.154071!3d16.800032!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfeb2d47e01a7bd4!2z5p2x5bGL44Ob44OG44Or77yIQXp1bWF5Ye-8iQ!5e0!3m2!1sja!2s!4v1555568682988!5m2!1sja!2s" frameborder="0" style="border:0; display: block; width: 100%; height: 50vh;" allowfullscreen></iframe>
                    </div>
                    <div class="col-12 p-3 text-center" style="background: #482979; border-bottom-left-radius: .5rem; border-bottom-right-radius: .5rem;box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important; margin-bottom: 15px;"><img alt="{{ $pageKeywords }}" src="{{ asset('customer/azumaya_massage/logo-az.png') }}" class="img-fluid" style="margin: auto; width: 150px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
