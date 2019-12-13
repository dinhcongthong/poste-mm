@extends('www.pages.job-searching.master')

@section('jobsearching-content')
    <h2 class="article-title text-job font-weight-bold">
        <span class="badge bg-job"><i class="fas fa-chevron-right"></i> {{ $article->type->name }}</span>
        求人情報
    </h2>
    <div class="clearfix" id="social-share-button">
        @include('www.includes.social-share-button')
    </div>
    <div class="detail">
        <div class="row info-item">
            <div class="col-12 col-lg-2 text-job">
                <i class="fas fa-building"></i> 会社名
            </div>
            <div class="col-12 col-lg-10">
                {{ $article->name }}
            </div>
        </div>
        @if ($article->quantity != 0)
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-users"></i>
                    採用人数
                </div>
                <div class="col-12 col-lg-10">
                    {{ $article->quantity }}
                </div>
            </div>
        @endif
        @if(!is_null($article->type))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-briefcase"></i>
                    職種
                </div>
                <div class="col-12 col-lg-10">
                    {{ $article->type->name }}
                </div>
            </div>
        @endif
        @if(!is_null($article->getNationality))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="far fa-flag"></i>
                    雇用人種
                </div>
                <div class="col-12 col-lg-10">
                    {{ $article->getNationality->name }}
                </div>
            </div>
        @endif
        @if(!is_null($article->category))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-suitcase"></i>
                    雇用形態
                </div>
                <div class="col-12 col-lg-10">
                    {{ $article->category->name }}
                </div>
            </div>
        @endif
        @if(!empty($article->requirement))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-tags"></i>
                    雇用資格
                </div>
                <div class="col-12 col-lg-10">
                    {!! $article->requirement !!}
                </div>
            </div>
        @endif
        @if(!empty($article->content))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-suitcase"></i>
                    仕事内容
                </div>
                <div class="col-12 col-lg-10">
                    {!! $article->content !!}
                </div>
            </div>
        @endif
        <div class="row info-item">
            <div class="col-12 col-lg-2 text-job">
                <i class="fas fa-map-marker-alt"></i>
                勤務地
            </div>
            <div class="col-12 col-lg-10">
                {{ $article->address }}
                @if(!is_null($article->city))
                    {{ ', '.$article->city->name }}
                @endif
            </div>
        </div>
        @if (!empty($article->salary))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-dollar-sign"></i>
                    給与
                </div>
                <div class="col-12 col-lg-10">
                    {{ $article->salary }}
                </div>
            </div>
        @endif
        @if (!empty($article->other_info))
            <div class="row info-item">
                <div class="col-12 col-lg-2 text-job">
                    <i class="fas fa-info-circle"></i>
                    備考
                </div>
                <div class="col-12 col-lg-10">
                    {!! $article->other_info !!}
                </div>
            </div>
        @endif
        <div class="row info-item">
            <div class="col-12 col-lg-2 text-job">
                <i class="fas fa-calendar-alt"></i> 更新日
            </div>
            <div class="col-12 col-lg-10">
                {{ date('Y-m-d', strtotime($article->updated_at)) }}
            </div>
        </div>
        <div class="row info-item justify-content-center">
            <button class="btn btn-job mx-1" type="button" data-toggle="modal" data-target="#classify-contact"><i class="fas fa-envelope"></i> 投稿者に連絡する</button>
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
                <form action="#" method="POST" id="contact-classify-form" data-key="{{ $article->id }}" data-type="job-searching">
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
