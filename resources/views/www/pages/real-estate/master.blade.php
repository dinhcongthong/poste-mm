@extends('www.layouts.master')

@section('content')
<div class="container mb-4">
    <div class="bg-white p-3" id="classify">
        <div class="page-title">
            <h2 class="title">
                <a href="{{ route('get_real_estate_index_route') }}">
                    <i class="fas fa-home"></i> 不動産情報 <small>Estate Information</small>
                </a>
            </h2>
        </div>
        <div class="page-content d-grid x1 x5-lg g-3">
            <div class="g-col-1">
                @include('www.pages.real-estate.left-side')
            </div>
            <div class="g-col-1 g-col-lg-4">
                <div class="search p-3">
                    @include('www.pages.real-estate.search')
                </div>
                <div class="seperate"></div>
                <div class="personal-list">
                    @yield('real-content')
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