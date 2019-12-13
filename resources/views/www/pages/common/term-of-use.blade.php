@extends('www.layouts.master')

@section('stylesheets')
<style>
    .list, .list li {
        line-height: 1.5;
        font-size: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container bg-white py-4 mb-4">
    <div class="col-xs-12 mb-20">
        <h2 class="border border-left-0 font-weight-bold border-right-0 border-top-0 border-dark">サイト利用に関するお約束</h2>
        <div class="heading-description" style="line-height: 22px;">
            <p>弊社のウェブサイト「POSTE（<a href="{{ URL::to('/') }}" style="color: blue;">https://poste-mm.com</a>）」（以下、「本サイト」）のご利用にあたっては、以下のご利用条件をお読みいただき、同意の上ご利用ください。同意いただけない場合は、ご利用をお断りさせていただきます。</p>
            <ol>
                <li>
                    <div>
                        <h3 class="text-bold font-size-15px">著作権について</h3>
                        <p>本サイトに掲載されている画像、文章、音声等すべての情報（以下、「コンテンツ」）の著作権は、弊社に帰属しています。ただし、弊社以外の著作者が存在する場合があり、その場合コンテンツの著作権は原則として各著作者に帰属しています。従って、お客様が私的利用のためにコンテンツを使用することはできますが、他の商業目的のウェブサイトや印刷物などに転用することは禁止されています。弊社及び著作者の許諾なしにコンテンツを使用した場合は、著作権法違反等にあたる可能性がありますので、ご注意ください。</p>
                    </div>
                </li>
                <li>
                    <div>
                        <h3 class="text-bold font-size-15px">商標類について</h3>
                        <p>本サイトで使用しているすべての名称、ロゴ、トレードマーク、サービスマーク（以下、総称して「商標類」）は、弊社が所有しているか、ライセンスに基づき使用されています。本サイトにおいては、お客様に対し商標類の使用を許諾しておりません。本サイトに掲載されている商標類の不正使用は、厳重に禁止されています。</p>
                    </div>
                </li>
                <li>
                    <div>
                        <h3 class="text-bold font-size-15px">リンクについて</h3>
                        <p>本サイトへのリンクは原則として自由ですが、リンクご希望の場合は、貴ホームページのURLを当社の<a href="{{ URL::to('/contact') }}" style="color: blue;">お問い合わせ窓口</a>までご連絡ください。</p>
                    </div>
                </li>
            </ol>
        </div>
    </div>
    <div class="col-12" style="border-bottom: 1px solid #ddd;">
        <h2 class="border border-left-0 font-weight-bold border-right-0 border-top-0 border-dark">ユーザー登録に関してのお約束</h2>
        <p class="text-justify list">
            POSTEを御利用頂き誠にありがとうございます。 以下の文章は、POSTEにてユーザー登録をされることにより、POSTEの利用者（以下、利用者と記します）の方々へ提供されるサービス（以下、サービスとして記す場合があります）ご利用頂く上でのお約束事を記しています。<br/>
            又利用者がサービスを利用される際、同意して頂いた事とさせて頂きます。
        </p>
        <ol class="list">
            <li class="text-justify">利用者の方々が、サービスご利用約款へ同意される場合、同時にすべてのPOSTEのサービスご利用約款（お約束）へも同意して頂いたものと見なします。</li>
            <li class="text-justify">POSTEはサービスを提供するにあたり、サービス提供の持続性、サービスに関する保証、サービス内で扱われる利用者情報の保証等一切の利用者がサービスを利用する事によりおこりうる事態の保証を致しません。</li>
            <li class="text-justify">利用者の方々が、各利用者は各募集企業に対して一般的に必要以上と思われる数回にわたって電信メールを送信しない事をお約束頂いたものとします。</li>
            <li class="text-justify">POSTEは、情報掲示板利用にあたり何らかの理由により電子メールが送信されなかった場合でも、一切の保証は致しません。</li>
            <li class="text-justify">利用者がサービスを利用される場合、POSTE「情報掲示板」でのコンテンツの掲載や、一般的に常識の限度を超えている判断される掲載は行わない事をお約束頂いたものとします。</li>
            <li class="text-justify">利用者はサービスを利用するにあたり、他の利用者の方々が一般的に迷惑と感じる一切の行動を行わない事をお約束頂いたものとします。</li>
            <li class="text-justify">利用者が投稿したデータ−、保存したデータ−など全ての利用者からインプットされた情報が消失するなどして、利用者が不利益を被った場合でも、POSTEは何らの責任も負わないものとします。</li>
            <li class="text-justify">全ての利用者から掲載、又はインプットされた情報（データ）の著作権はPOSTEに帰属するものとします。</li>
            <li class="text-justify">
                POSTEは利用者によりシステム内に登録・掲載されたデータ−を他媒体へ掲載・転用する事が出来る事とします。この場合、POSTEは原則として利用者によりシステム内に登録・掲載されたデータ−をそのまま利用する事とし、他媒体へ掲載される期間、内容、文言、映画像、その他著作権物等のデータ−管理は利用者に付随する事とします。<br/>
                又、データ−掲載・転用が原因による利用者、第三者間での問題、及びPOSTEが利用者、第三者間の問題であると判断する場合において、その一切の責任は利用者にある事とします。<br/>
                POSTEは利用者、第三者間においての起訴、損害賠償請求等の問題へ関与は一切行わない事とします。尚、POSTEは媒体に応じて一部データ−の編集が必要である場合及びそう判断される場合、その内容を自在に変更する事が可能とします。
            </li>
            <li class="text-justify">POSTEは、POSTEの定めた掲載期間以降に、利用者によるシステム内のデータ−編集を行うことにより生じる、他媒体内容変更及びそれらデータ−の他媒体への反映を一切受け付けない事とします。又掲載期間は利用者の責任においてPOSTEへ確認する事とし、掲載期間後に利用者により変更されたシステム内のデータ−が、他媒体に反映されない事が原因により生じうる一切の責任は利用者に付随する事とします</li>
            <li class="text-justify">利用者は、POSTEによるシステム内のデータ−他媒体掲載・転用を拒否することは原則として出来ない事とします。但し、POSTEが他媒体へ掲載する事によりPOSTE自身が損害を被ると判断した場合、及び利用者によりPOSTEの他媒体掲載・転用行為が利用者の多大な被害に繋がる可能性をPOSTEに明示し、POSTEもその明示に同意する場合においては、この限りではない事とします。</li>
            <li class="text-justify">POSTEはサイト管理等を目的として、サービスを利用する利用者の監視する場合があります。</li>
            <li class="text-justify">POSTEは利用者を利用者として好ましくないと判断した場合、利用者の許可・通知無く書きこみを消去し、利用者のサービスの利用をお断りする場合があります。</li>
            <li class="text-justify">POSTEは最新情報の通知、又はそれ以外の事情により利用者の許可無く利用者へ電子メールの配信を行う場合がございます。</li>
            <li class="text-justify">本約款はいかなる場合においても利用者への予告なしに変更される場合があります。又、本約款内容の変更により生じうる一切のトラブルの保証は致しません。</li>
        </ol>
    </div>
    <div class="col-12 clearfix pt-3">
        <span class="float-right"> Copyright © POSTE Co.,Ltd. All rights reserved.</span>
    </div>
</div>
@endsection
