@extends('www.pages.personal-trading.master')

@section('personal-content')
<h2 class="article-title text-primary font-weight-bold">
    <span class="badge badge-primary"><i class="fas fa-chevron-right"></i> {{ $article->type->value }}</span>
    {{ $article->name }}
</h2>
<div class="clearfix" id="social-share-button">
    @include('www.includes.social-share-button')
</div>
<div class="detail">
    <div class="row text-center justify-content-center align-items-end mb-2" id="popup-image">
        @if(!is_null($article->getFirstImage))
        <a href="{{ App\Models\Base::getUploadURL($article->getFirstImage->name, $article->getFirstImage->dir) }}" title="{{ $article->name }}" class="mx-1">
            <img class="featured-image" src="{{ App\Models\Base::getUploadURL($article->getFirstImage->name, $article->getFirstImage->dir) }}" alt="{{ $article->name }}">
        </a>
        @endif
        @if(!is_null($article->getSecondImage))
        <a href="{{ App\Models\Base::getUploadURL($article->getSecondImage->name, $article->getSecondImage->dir) }}" title="{{ $article->name }}" class="mx-1">
            <img class="featured-image" src="{{ App\Models\Base::getUploadURL($article->getSecondImage->name, $article->getSecondImage->dir) }}" alt="{{ $article->name }}">
        </a>
        @endif
    </div>
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            ジャンル別表示
        </div>
        <div class="col-12 col-lg-9">
            {{ $article->category->name }}
        </div>
    </div>
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            <i class="fas fa-dollar-sign"></i> 希望価格
        </div>
        <div class="col-12 col-lg-9">
            {{ $article->price }}
        </div>
    </div>
    @if(!empty($article->address))
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            <i class="fas fa-map-marker-alt"></i> 場所
        </div>
        <div class="col-12 col-lg-9">
            {{ $article->address }}
        </div>
    </div>
    @endif
    @if(!is_null($article->delivery))
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            <i class="fas fa-bus"></i> 商品受け渡し方法
        </div>
        <div class="col-12 col-lg-9">
            {{ $article->delivery->value }}
        </div>
    </div>
    @endif
    @if(!empty($article->content))
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            <i class="fas fa-info-circle"></i> 希望価格
        </div>
        <div class="col-12 col-lg-9">
            {!! $article->content !!}
        </div>
    </div>
    @endif
    <div class="row info-item">
        <div class="col-12 col-lg-3 text-primary">
            <i class="fas fa-calendar-alt"></i> 更新日
        </div>
        <div class="col-12 col-lg-9">
            {{ date('Y-m-d', strtotime($article->updated_at)) }}
        </div>
    </div>
    <div class="row info-item justify-content-center">
        <button class="btn btn-primary mx-1" type="button" data-toggle="modal" data-target="#classify-contact"><i class="fas fa-envelope"></i> 投稿者に連絡する</button>
        @if($article->show_phone_num)
        @php
        $phone = !empty($article->phone) ? $article->phone : $article->getUser->phone;
        $phone = str_replace('-', '', $phone);
        @endphp
        <a href="tel:{{ $phone }}" class="btn btn-outline-secondary mx-1"><i class="fas fa-phone"></i> {{ $phone  }}</a>
        @endif
    </div>
</div>


<div class="modal fade" id="classify-contact" tabindex="-1" role="dialog" aria-labelledby="classify-contact-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classify-contact-title">投稿者に連絡する</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="contact-classify-form" data-key="{{ $article->id }}" data-type="personal">
                <div class="modal-body">
                    @csrf
                   <div class="form-group row">
                        <label class="col-12 col-lg-3 col-form-label text-right">氏名 </label>
                        <div class="col-12 col-lg-9">
                            @if(Auth::check())
                                <input type="text" class="form-control" name="contact_classify_name" value="{{ getUsername(Auth::user()) }}" required>
                            @else
                                <input type="text" class="form-control" name="contact_classify_name" required>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-3 col-form-label text-right">メールアドレス</label>
                        <div class="col-12 col-lg-9">
                            @if(Auth::check())
                                <input type="email" class="form-control" name="contact_classify_email" value="{{ Auth::user()->email }}" required>
                            @else
                                <input type="email" class="form-control" name="contact_classify_email" required>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-3 col-form-label text-right">件名 </label>
                        <div class="col-12 col-lg-9">
                            <input type="text" class="form-control" name="contact_classify_subject" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-3 col-form-label text-right">お問い合わせ内容 </label>
                        <div class="col-12 col-lg-9">
                            <textarea class="form-control" rows="3" name="contact_classify_message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="mail_feedback" class="btn btn-primary"><i class="fas fa-paper-plane"></i> 送信</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
