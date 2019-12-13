@extends('www.layouts.master')

@section('content')
    <div id="business-content" class="container mt-0 mt-lg-4">
        <div class="page-intro mb-4 rounded d-flex flex-column justify-content-between">
            <img src="{{ asset('images/poste/bsn-bg1.png') }}" class="img-fluid">
            <img src="{{ asset('images/poste/bsn-bg2.png') }}" class="img-fluid d-none d-md-block">
            <div class="introduction p-2 p-lg-5">
                <h1 class="text-center font-weight-bold text-serif mt-5"><span>POSTE</span><span>ビジネス</span></h1>
                <p class="col-12 text-center text-serif">
                    <span>日系企業の進出が相次ぐミャンマー。</span>
                    <span>日本語の情報不足でビジネスチャンスを逃していませんか？</span> <br>
                    <span>ポステが在ミャンマー企業とミャンマー進出予定の日系企業のプラットフォームとなり、</span><span>ビジネスチャンスを拡大させます。</span>
                </p>
            </div>
        </div>

        <div id="business-page-grid" class="d-grid x12 g-3 g-lg-4 mb-3 mb-lg-4">
            {{-- pc navigator --}}
            <div id="business-nav" class="g-col-3 d-none d-lg-block">
                <div class="bg-light rounded sticky-top my-sticky-top p-3">
                <div id="business-filter" style="z-index: 1010; max-height: calc(100vh - 94px);">
                    @include('www.pages.business.category-sidebar')
                </div>
            </div>
        </div>
        {{-- end pc navigator --}}

        {{-- list of items --}}
        <div id="business-lists" class="nested g-col-12 g-col-lg-6">
            <div class="g-col-12">
                @isset($parent_category)
                    <div class="py-2 mb-4 bg-white">
                        <h2 class="text-center">{{ $parent_category->name }}</h2>
                    </div>
                @endisset
                @forelse ($business_list as $article)
                    @php
                    if($article->fee == App\Models\PosteTown::SALE_INFORMING && $article->end_date >= date('Y-m-d') && $article->start_date <= date('Y-m-d')) {
                        $is_premium = true;
                    } else {
                        if($article->end_free_date >= date('Y-m-d')) {
                            $is_premium = true;
                        } else {
                            $is_premium = false;
                        }
                    }
                    @endphp
                    <div class="business-show-item {{ $is_premium ? 'sponsored' : '' }}">
                        <div class="col-12 p-0 business-cat btn-group justify-content-end mb-3">
                            @foreach ($article->getCategories as $cate)
                                <a href="{{ route('get_business_category_route', $cate->slug.'-'.$cate->id) }}" class="btn btn-sm btn-outline-success">{{ $cate->name }}</a>
                            @endforeach
                        </div>
                        <div class="col-2 p-0">
                            <a href="{{ route('get_business_detail_route', $article->slug.'-'.$article->id) }}">
                                <img src="{{ App\Models\Base::getUploadURL($article->getThumb->name, $article->getThumb->dir) }}" class="img-contain">
                            </a>
                        </div>
                        <div class="col-10">
                            <a href="{{ route('get_business_detail_route', $article->slug.'-'.$article->id) }}" class="business-name">
                                {{ $article->name}} {!! $is_premium ? '<i class="material-icons text-success">verified_user</i>' : '' !!}</a>
                            <div class="business-des d-block">
                                <a href="{{ route('get_business_detail_route', $article->slug.'-'.$article->id) }}" class="business-desc">
                                    <p class="text-truncate">{{ $article->description }}</p>
                                    <p class="m-0">
                                        <strong>住所: </strong> {{ $article->public_address ? $article->address : '非公開' }}<br/>
                                        <strong>メール: </strong> {{ $article->public_email ? $article->email : '非公開' }}<br/>
                                        <strong>電話番号: </strong> {{ $article->public_phone ? $article->phone : '非公開' }}<br/>
                                    </p>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="g-col-12 text-center">
                        <div class="alert alert-warning">
                            Now, we don't have any store in this category
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        {{-- End list of items --}}

        {{-- sidebar --}}
        <div id="business-sidebar" class="g-col-3 d-none d-lg-block">
            <div id="sticky-sidebar" class="sticky-top my-sticky-top">
                <a href="{{ route('get_business_new_route') }}" class="btn btn-outline-danger btn-lg btn-block mb-4 fw-bold">無料でページを作成する</a>
                {{-- <a href="#" class="btn-block rounded shadow-sm hover mb-4"><img src="{{ asset('images/poste/business-banner.png') }}" class="img-fluid rounded"></a>
                <a href="#" class="btn-block rounded shadow-sm hover mb-4"><img src="{{ asset('images/poste/flyer-poste-mm-2.png') }}" class="img-fluid rounded"></a> --}}
            </div>
        </div>
        {{-- end sidebar --}}
    </div>
</div>

<!-- mobile navigator -->
<div class="business-nav bg-grey d-flex d-lg-none flex-wrap accordion">
    <div class="row border-top w-100 m-0" style="height: 60px;">
        <a class="nav-link text-center" data-toggle="collapse" href="#businessFilter" role="button" aria-expanded="false" aria-controls="businessFilter"><i class="material-icons d-block">tune</i><small>Categories</small></a>
        <a class="nav-link text-center" data-toggle="collapse" href="#businessSearch" role="button" aria-expanded="false" aria-controls="businessSearch"><i class="material-icons d-block">search</i><small>Search</small></a>
    </div>
    <div class="collapse bg-white col-12 p-0" id="businessFilter" data-parent=".business-nav">
        <div class="bg-grey rounded w-25 mx-auto mt-3" style="height: 5px;"></div>
        <div id="business-filter" class="px-3">
            @foreach ($businessCategoryList as $item)
                @php
                $childList = $item->getChildrenCategory;
                $totalPost = $childList->reduce(function($total, $child) {
                    return $total += $child->getBusinesses->count();
                }, 0);
                @endphp
                <p class="m-0">
                    <a class="nav-link btn-dropdown" data-toggle="collapse" href="#mb-cate-{{ $item->id }}" role="button" aria-expanded="false" aria-controls="mb-cate-{{ $item->id }}">
                        {{ $item->name }}
                        @if($totalPost > 0)
                            <span class="badge badge-danger badge-pill">{{ $totalPost }}</span>
                        @endif
                    </a>
                </p>
                <div class="collapse show px-3" id="mb-cate-{{ $item->id }}">
                    @foreach ($childList as $child)
                        @php
                        $total = $child->getBusinesses->count();
                        @endphp
                        <a class="nav-link text-danger" href="{{ route('get_business_category_route', $child->slug.'-'.$child->id) }}" >
                            {{ $child->name }}
                            @if($total > 0)
                                <span class="sub-article-num">
                                    {{ $total }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
                @if(!$loop->last)
                    <div class="dropdown-divider"></div>
                @endif
            @endforeach
        </div>
        <div class="bg-grey rounded w-25 mx-auto mb-3" style="height: 5px;"></div>
    </div>
    <div class="collapse bg-white col-12 p-3" id="businessSearch" data-parent=".business-nav">
        <form class="form-inline">
            <input id="b-search-input" class="form-control mr-sm-2" type="search" placeholder="Enter keyword..." aria-label="Search">
        </form>
    </div>
</div>
@endsection
