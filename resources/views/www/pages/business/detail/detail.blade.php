@extends('www.layouts.master')

@section('content')
    @php
    if($business_item->fee == App\Models\PosteTown::SALE_INFORMING && $business_item->end_date >= date('Y-m-d') && $business_item->start_date <= date('Y-m-d')) {
        $is_premium = true;
    } else {
        if($business_item->end_free_date >= date('Y-m-d')) {
            $is_premium = true;
        } else {
            $is_premium = false;
        }
    }
@endphp
<div id="business-content" class="container">
    <div class="business-nav bg-grey d-flex d-lg-none">
        <a href="#company-des" class="nav-link"><i class="material-icons">business_center</i></a>
        <a href="#company-phone" class="nav-link"><i class="material-icons">phone</i></a>
        @if($is_premium)
            <a href="#company-map" class="nav-link"><i class="material-icons">map</i></a>
        @endif
        <a href="#" class="nav-link" data-toggle="modal" data-target="#feedback-modal"><i class="material-icons">edit</i></a>
    </div>
    {{-- Category Menu --}}
    <div class="w-100 mb-4">
        <div id="header-cate-list" class="swiper-container pb-3 pb-lg-0">
            @include('www.pages.business.cate-swiper')
        </div>
    </div>
</div>
{{-- End Category Menu --}}

{{-- Item's Category --}}
<div class="container">
    <div id="company-header" class="wrapper company-internet g-col-12 rounded rounded-bottom-0 p-3 p-lg-4 d-flex flex-wrap align-items-center">
        <div class="col p-0 text-light">
            @foreach ($business_item->getCategories as $cate)
                @if($loop->first)
                    {{ $cate->name }}
                @else
                    {{ '・'.$cate->name }}
                @endif
            @endforeach
            <h2 class="fw-bold m-0">{{ $business_item->name }}</h2>
        </div>

        <div class="flex-shrink-1">
            <button class="col btn {{ $liked ? 'btn-saved' : 'btn-save' }}" data-toggle="modal" data-target="#save-modal" data-id="{{ $business_item->id }}" data-type="business" id="btn-save">Save</button>
            {{-- <button class="col btn btn-share">Share</button> --}}
        </div>
    </div>
</div>
{{-- End Item's Category --}}

{{-- Business Info --}}
<div id="company-grid" class="d-grid x12 g-3 g-lg-4 mb-3 mb-lg-4 container">

    <div id="business-sidebar" class="g-col-12 g-col-md-3 px-0 d-none d-lg-block">
        <div id="sticky-sidebar" class="sticky-top sticky-top-except-nav bg-white p-4 rounded scrollspy-bar" style="z-index:0;">
            <a href="#company-des" class="btn btn-outline-success btn-lg btn-block">会社概要</a>
            <a href="#company-phone" class="btn btn-outline-success btn-lg btn-block">電話番号</a>
            @if($is_premium)
                <a href="#company-map" class="btn btn-outline-success btn-lg btn-block">住所</a>
            @endif
            <a href="#" class="btn btn-primary btn-lg btn-block"  data-toggle="modal" data-target="#feedback-modal">提案を編集する</a>
        </div>
    </div>
    <div id="company-info" class="g-col-12 g-col-lg-9">
        {{-- Name - Thumbnail - Description --}}
        <div class="company-intro bg-white px-3 px-lg-4 pt-3 pt-lg-4 mb-3 mb-lg-4 rounded rounded-top-0">
            <div id="company-des">
                @include('www..pages.business.detail.intro')
            </div>
        </div>
        {{-- End Name - Thumbnail - Description --}}

        {{-- Basic Info --}}
        <div class="company-intro bg-white px-3 px-lg-4 pt-3 pt-lg-4 mb-3 mb-lg-4 rounded">
            @include('www.pages.business.detail.basic-info')
        </div>
        {{-- End Basic Info --}}

        @if($is_premium)

            {{-- Service List --}}
            @if(!$business_item->getServiceList->isEmpty())
                <div class="company-services bg-white px-3 px-lg-4 py-3 py-lg-4 mb-3 mb-lg-4 rounded">
                    <h2 class="m-0">サービス紹介</h2>
                    <div class="divider mb-4"></div>

                    @include('www.pages.business.detail.services')
                </div>
            @endif
            {{-- End Service List --}}

            {{-- Gallery --}}
            @if(!$business_item->getGalleries->isEmpty())
                <div class="company-services bg-white px-3 px-lg-4 py-3 py-lg-4 mb-3 mb-lg-4 rounded">
                    <h2 class="m-0">イメージ</h2>
                    <div class="divider mb-4"></div>

                    @include('www.pages.business.detail.gallery')
                </div>
            @endif
            {{-- End Gallery --}}

            @if(!empty($business_item->pdf_url))
                @include('www.pages.business.detail.pdf')
            @endif

            {{-- Address and Map --}}
            <div class="company-maps bg-white p-3 p-lg-4 overflow-hidden {{ !$business_item->getBusinessRelateList->isEmpty() ? 'mb-3 mb-lg-4' : '' }} rounded">
                <div id="company-map">
                    <h2 class="m-0">経路案内</h2>
                    <div class="divider mb-4"></div>
                </div>

                @include('www.pages.business.detail.map')
            </div>
            {{-- End Address and Map --}}

            @if (!$business_item->getBusinessRelateList->isEmpty())
                <div class="company-relate bg-white px-3 px-lg-4 py-3 py-lg-4 rounded">
                    <h2 class="m-0">関連企業</h2>
                    <div class="divider mb-4"></div>

                    @include('www.pages.business.detail.relate')
                </div>
            @endif
        @endif
    </div>
    {{-- End Business Info --}}
</div>


<div class="modal fade" style="z-index: 10000" id="feedback-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 10px;">
            <form action="#" method="POST" id="feedback-form">
                <input type="hidden" name="post_id" value="{{ $business_item->id }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-pen mr-3"></i> Improve this listing </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if(!Auth::Check())
                        <div class="form-group">
                            <label class="font-weight-bold" for="feedback-name">Name: </label>
                            <input type="text" name="name" id="feedback-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="feedback-email">Email: </label>
                            <input type="email" name="email" id="feedback-email" class="form-control" required>
                        </div>
                    @else
                        <input type="hidden" name="name" value="{{getUsername(Auth::user())}}">
                        <input type="hidden" name="email" value="{{ isset(Auth::user()->email) ? Auth::user()->email : 'none' }}">
                    @endif
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" for="subject">Subject</label>
                        <input class="form-control" name="subject" rows="10" id="subject">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" for="content">Content</label>
                        <textarea class="form-control" name="content" rows="10" id="content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="mail_feedback" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <div class="business-nav bg-grey d-flex d-lg-none">
<a href="#company-general" class="nav-link"><i class="material-icons">business_center</i></a>
<a href="#company-phone" class="nav-link"><i class="material-icons">phone</i></a>
<a href="#company-map" class="nav-link"><i class="material-icons">map</i></a>
<a href="#company-general" class="nav-link" data-toggle="modal" data-target="#feedback-modal"><i class="material-icons">edit</i></a>
</div> --}}


<!-- ----- -->
<!-- Modal alert when save or unsave -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" id="save-modal"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="z-index: 10000;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div id="saved-result" class="p-3 bg-success text-white"></div>
    </div>
</div>

<script type="text/javascript">
setInterval(function(){
    $('#save-modal').modal('hide');
}, 2000);
</script>
@endsection
