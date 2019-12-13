@extends('www.layouts.master')

@section('content')
<div class="container mb-4">
    <div class="bg-white p-3" id="classify">
        <div class="page-title">
            <h2 class="title">
                <a href="{{ route('get_bullboard_index_route') }}">
                    <i class="fas fa-desktop"></i> 情報掲示板 <small>Information Bullboard</small>
                </a>
            </h2>
        </div>
        <div class="page-content d-grid x1 x5-lg g-3">
            <div class="g-col-1">
                @include('www.pages.bullboard.left-side')
            </div>
            <div class="g-col-1 g-col-lg-4">
                <div class="search p-3">
                    @include('www.pages.bullboard.search-form')
                </div>
                <div class="seperate"></div>
                <div class="personal-list">
                    <h3 class="title">削除・変更 </h3>
                    <p class="text-center p-alert">
                        ＊投稿の内容を確認し、POSTE運営事務局の判断により不適切と判断した場合は投稿を承認しない場合がございますのでご了承ください＊
                    </p>
                    
                    <div id="data-table">
                        @include('www.pages.bullboard.list-table')
                    </div>
                </div>
            </div>
        </div>
        <div class="seperate"></div>
        <div class="related">
            @include('www.includes.classify-bottom')
        </div>
    </div>
</div>
@endsection