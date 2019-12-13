@extends('www.layouts.master')

@section('content')
<div class="container">
    <div class="bg-white mb-4">
        <div class="bg-golf">
            <img class="img-fluid" src="{{ asset('images/poste/golf-banner.jpg') }}">
        </div>
        {{-- Premium List --}}
        <div class="golf-content golf-list" id="golf-premium-list">
            <div class="golf-heading">
                <img src="{{ asset('images/poste/golf-heading.png') }}">
                <h2 class="golf-title">おすすめゴルフ場</h2>
            </div>
            <div class="golf-body p-4">
                <div id="golf-list">
                    @forelse ($golfList as $item)
                    <div class="golf-premium-item golf-item p-3">
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <a href="{{ route('get_golf_detail_route', $item->slug.'-'.$item->id) }}">
                                    <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}">
                                </a>
                            </div>
                            <div class="col-12 col-lg-9">
                                <h3 class="title">
                                    <a href="{{ route('get_golf_detail_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
                                </h3>
                                <div class="description">
                                    <a href="{{ route('get_golf_detail_route', $item->slug.'-'.$item->id) }}" class="poem max-line-3" data-lining>
                                        {!! $item->description !!}
                                    </a>
                                </div>
                                <div class="info mt-3">
                                    <div class="row">
                                        <div class="col-12 col-md-10">
                                            <a href="#" target="_blank" class="label-address"><span class="label">住所</span> 
                                                {{ $item->address }}
                                                @isset($item->getDistrict)
                                                {{ ', '.$item->getDistrict->name }}
                                                @endisset 
                                                @isset($item->getCity)
                                                {{ ', '.$item->getCity->name }}
                                                @endisset
                                            </a>
                                            <br/>
                                            <br/>
                                            <a href="tel:{{ $item->phone }}" class="label-phone"><span class="label">TEL</span> {{ $item->phone }}</a>
                                        </div>
                                        <div class="col-12 col-md-2 d-flex align-items-end">
                                            <a href="{{ route('get_golf_detail_route', $item->slug.'-'.$item->id) }}" target="_blank" class="ml-auto">
                                                <span class="label label-info"><i class="fas fa-info-circle text-white"></i> 詳細</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    @empty
                    <div class="golf-premium-item golf-item p-3">
                        NO DATA
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- End Premium List --}}
        
        {{-- Golf Shop --}}
        <div class="golf-content golf-list" id="golf-premium-list">
            <div class="golf-heading">
                <img src="{{ asset('images/poste/golf-heading.png') }}">
                <h2 class="golf-title">おすすめのゴルフショップ</h2>
            </div>
            <div class="golf-body p-4">
                <div id="golf-list">
                    @forelse ($golfShopList as $item)
                    <div class="golf-premium-item golf-item p-3">
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <a href="{{ route('get_golf_shop_detail_route', $item->slug.'-'.$item->id) }}">
                                    <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}">
                                </a>
                            </div>
                            <div class="col-12 col-lg-9">
                                <h3 class="title"><a href="{{ route('get_golf_shop_detail_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a></h3>
                                <div class="description">
                                    <a href="{{ route('get_golf_shop_detail_route', $item->slug.'-'.$item->id) }}" class="poem max-line-3" data-lining data-auto-resize>
                                        {{ $item->description }}                                        
                                    </a>
                                </div>
                                <div class="info mt-3">
                                    <div class="row">
                                        <div class="col-12 col-md-10">
                                            <a href="#" target="_blank" class="label-address"><span class="label">住所</span>Royal Cambodia Phnom Penh Golf Club, Sen Sok, Phnom Penh Municipality</a><br/>
                                            <br/>
                                            <a href="tel:{{ $item->phone }}" class="label-phone"><span class="label">TEL</span> {{ $item->phone }}</a>
                                        </div>
                                        <div class="col-12 col-md-2 d-flex align-items-end">
                                            <a href="{{ route('get_golf_shop_detail_route', $item->slug.'-'.$item->id) }}" target="_blank" class="ml-auto">
                                                <span class="label label-info"><i class="fas fa-info-circle text-white"></i> 詳細</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                     <div class="golf-premium-item golf-item p-3">
                         NO DATA
                     </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- End Golf Shop --}}
    </div>
</div>
@endsection