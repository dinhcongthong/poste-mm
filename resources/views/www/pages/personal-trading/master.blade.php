@extends('www.layouts.master')

@section('content')
<div class="container mb-4">
    <div class="bg-white p-3" id="classify">
        <div class="page-title">
            <h2 class="title">
                <a href="{{ route('get_personal_trading_index_route') }}">
                    <i class="fas fa-shopping-cart"></i> 個人売買 <small>Personal Trading</small>
                </a>
            </h2>
        </div>
        <div class="page-content d-grid x1 x5-lg g-3">
            <div class="g-col-1">
                @include('www.pages.personal-trading.left-side')
            </div>
            <div class="g-col-1 g-col-lg-4">
                <div class="search p-3">
                    @include('www.pages.personal-trading.search')
                </div>
                <div class="seperate"></div>
                <div class="personal-list">
                    @yield('personal-content')
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