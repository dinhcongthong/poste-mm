@extends('www.layouts.master')

@section('stylesheets')
    <style>

    </style>
@endsection

@section('content')
    <div id="business-content" class="container">
        <input type="hidden" name="business_id" value="{{ $business_id }}">

        {{-- Basic Info --}}
        <form id="basic-info-form">
            <div id="company-grid" class="wrapper d-grid x12 g-3 g-lg-4 mb-3 mb-lg-4">
                @include('www.pages.business.update.basic-info-form')
            </div>
        </form>
        {{-- End Basic Info --}}

        {{-- Service Form --}}
        <div id="company-services" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4">
            <h2 class="m-0">サービス紹介</h2>
            <div class="divider mb-4"></div>

            @include('www.pages.business.update.services-form')
        </div>
        {{-- End Service Form --}}

        {{-- Gallery Form --}}
        <div id="company-gallery" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4">
            @include('www.pages.business.update.gallery')
        </div>
        {{-- End Gallery Form --}}


        {{-- PDF Form  --}}
        <div id="company-pdf" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4">
            <div class="row d-none" id="pdf_error"></div>
            <h2 class="m-0">PDF File</h2>

            @include('www.pages.business.update.pdf-form')
        </div>
        {{-- End PDF Form  --}}


        {{-- Address and Map --}}
        <div id="company-map" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4">
            <h2 class="m-0">経路案内</h2>
            <div class="divider mb-4"></div>

            @include('www.pages.business.update.map-address')
        </div>
        {{-- End Address and Map --}}

        {{-- Related Business --}}
        <div id="company-relate" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4">
            <h2 class="m-0">関連企業</h2>
            <div class="divider mb-4"></div>

            @include('www.pages.business.update.related-business')
        </div>
        {{-- End Related Business --}}

        {{-- Submit Button --}}
        <div id="company-save" class="wrapper g-lg-4 mb-3 mb-lg-4 p-3 p-lg-4 text-center">
            <button class="btn btn-success btn-lg mr-2" type="submit">SAVE</button>
            <a class="btn btn-outline-danger btn-lg ml-2" href="{{ route('get_business_index_route') }}">BACK</a>
        </div>
        {{-- End Submit Button --}}
    </div>
@endsection
