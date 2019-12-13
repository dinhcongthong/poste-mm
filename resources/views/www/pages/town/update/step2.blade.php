@extends('www.layouts.master')

@section('content')
<div id="loading" class="bg-white w-100 h-100 text-center mb-4 d-none">
    <div class="container d-flex align-items-center" style="min-height: 50vh;">
        <div class="text-center w-100">
            <img class="img-fluid" src="{{ asset('images/poste/loader_1.gif') }}" style="max-width: 80px;" alt="Processing">
            <h2>
                Your Info is being updated<br/>
                Please Wait...
            </h2>
        </div>
    </div>
</div>
<div id="shop-update" class="container mt-0 mt-lg-4 px-0 px-lg-3">
    <div id="premium-detail-grid" class="d-grid x12 g-0 g-lg-4">
        {{--  <div id="premium-info-list-mobile" class="g-col-12 navbar navbar-dark bg-dark scrollspy-bar list-group sticky-top d-lg-none p-0 shadow-sm" style="top:70px;">
            @include('www.pages.town.update.navbar-mobile')
        </div>  --}}

        <input type="hidden" name="category_id" value="{{ $category_item->id }}">
        <input type="hidden" name="town_id" value="{{ $town_id }}">
        <div class="g-col-12 bg-white text-center py-4 category-icon">
            <img src="{{ App\Models\Base::getUploadURL($category_item->getIcon->name, $category_item->getIcon->dir) }}" alt="{{ $category_item->name }}">
            {{ $category_item->name }}
        </div>
        <div id="shop-basic-info" class="g-col-12 wrapper overflow-hidden row m-0 pb-1 pb-lg-0 town3">
            {{-- Show basic info error when submit --}}
            <div id="basic-info-error" class="g-col-12 mb-0 w-100">
            </div>
            {{-- End Show basic info error when submit --}}
            @include('www.pages.town.update.basic-info-form')
        </div>

        <div id="shop-premium-info" class="nested x12 g-col-12 g-3 g-lg-4 p-3 px-md-0">

            @include('www.pages.town.update.scrollspy')

            <div class="nested x12 g-col-12 g-col-lg-9">
                <div class="premium-info nested x12 g-col-12">
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="about">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-bullhorn mr-3"></i>概要 <small><i>(Description)</i></small></h3>
                            <div class="p-3 p-lg-4">
                                <textarea class="form-control" rows="6" name="description">{{ $description }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if(isset($working_time))
                    <div class="g-col-12 wrapper">
                        <div id="working-time">
                            <h3 class="px-3 px-lg-4 py-3"><i class="far fa-clock mr-3"></i>営業時間 <small><i>(Working Time)</i></small></h3>
                            <div class="p-3 p-lg-4">
                                @include('www.pages.town.update.working-time')
                            </div>
                        </div>
                    </div>

                    {{-- <div class="g-col-12 wrapper">
                        <div id="regular-time">
                            <h3 class="px-3 px-lg-4 py-3"><i class="far fa-clock mr-3"></i>定休日 <small><i>(Regular Closing Day)</i></small></h3>
                            <div class="p-3 p-lg-4">
                                @include('www.pages.town.update.regular-close')
                            </div>
                        </div>
                    </div> --}}
                    @endif
                    <div class="g-col-12 wrapper">
                        @include('www.pages.town.update.features-form')
                    </div>
                    @if(!in_array($category_item->id, array(70, 74)))
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="menu">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-bullhorn mr-3"></i>メニュー {{ in_array($category_item->id, array(68, 71, 72, 73)) ? '/ Menu' : ($category_item->id == 69 ? '/ Products' : '') }}</small></h3>
                            <div class="p-4">
                               @include('www.pages.town.update.menu')
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="gallery">
                            <h3 class="px-3 px-lg-4 py-3"><i class="far fa-images mr-3"></i>写真 / Images</h3>
                            @include('www.pages.town.update.gallery')
                        </div>
                    </div>

                    <div class="g-col-12 wrapper overflow-hidden">
                        <div id="map">
                            <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-map-marked-alt mr-3"></i>マップ / Map</h3>
                            @include('www.pages.town.update.map')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- mobile navigator --}}
    <div class="premium-nav-mobile bg-grey d-flex d-lg-none flex-wrap accordion">
        <div class="row border-top w-100 no-gutters" style="height: 60px;">
            <div class="col-6">
                <button type="submit" class="btn btn-success btn-block rounded-0 h-100" style="font-size: 1.3rem;">
                    <i class="far fa-save mr-1" style="font-size: 1.3rem;"></i>
                    保存（Save）
                </button>
            </div>
            <div class="col-6">
                <a href="{{ route('get_town_new_route') }}" class="btn btn-danger btn-block rounded-0 h-100 p-auto d-flex align-items-center justify-content-center flex-wrap" style="font-size: 1.3rem;">
                    <i class="fas fa-backward mr-1" style="font-size: 1.3rem;"></i>
                    一覧ページへ戻る（Back）
                </a>
            </div>
        </div>
    </div>
</div>
{{-- end mobile navigator --}}
</div>
@endsection
