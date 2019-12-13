@extends('www.layouts.master')

@section('content')

    @include('www.pages.town.header-intro')

    {{-- Main contents  --}}
    <div id="premium-content" class="container mt-3 mt-lg-4">
        <div id="premium-search" class="d-none d-lg-block rounded p-4 shadow-sm mb-3 mb-lg-4">
            <form class="form-inline rounded p-2 p-md-3" method="GET" action="{{ route('get_town_index_route') }}">
                <select name="search_category" class="col-12 col-md form-control custom-select border-bottom h-auto py-3 py-md-1 px-3 mr-0 mr-md-3" id="category-select">
                    <option value="0">Choose Category...</option>
                    @foreach ($posteTownCategoryList as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <input name="keywords" id="form-search" class="col form-control pt-3 pt-md-1 px-3 mt-2 mt-md-0" type="search" placeholder="キーワードを入力" aria-label="Search" style="min-width:0;">
                <button type="submit" class="col-auto btn material-icons pt-3 pt-md-1 px-4 mt-2 mt-md-0">search</button>
            </form>
        </div>

        <div id="premium-page-grid" class="d-grid x12 g-3 g-lg-4 mb-3 mb-lg-4">
            <!-- pc navigator -->
            <div id="premium-nav" class="g-col-3 d-none d-lg-block">
                <div id="premium-filter" class="sticky-top sticky-top-except-nav rounded list-group pr-3" style="z-index: 1010; margin-right: -1rem;">
                    <a href="{{ route('get_town_index_route') }}" class="list-group-item list-group-item-action town1 {{ $category_id == 0 ? 'active' : '' }}">おすすめスポット</a>
                    @foreach ($posteTownCategoryList as $item)
                        <a href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}" class="list-group-item list-group-item-action town{{ $loop->index + 2 }} {{ $category_id == $item->id ? 'active' : '' }}">{{ $item->name }}</a>
                    @endforeach
                </div>
            </div>

            {{-- list of shops  --}}
            <div id="premium-lists" class="nested g-col-12 g-col-lg-9">
                {{-- sponsored items  --}}
                <div id="sponsored-items" class="nested x12">
                    @forelse ($town_list as $item)

                        @php
                        if($item->fee == App\Models\PosteTown::SALE_INFORMING && $item->end_date >= date('Y-m-d') && $item->start_date <= date('Y-m-d')) {
                            $is_premium = true;
                        } else {
                            if($item->end_free_date >= date('Y-m-d')) {
                                $is_premium = true;
                            } else {
                                $is_premium = false;
                            }
                        }
                        @endphp

                        <div class="premium-item g-col-12 g-col-lg-4 {{ $is_premium ? 'sponsored' : '' }}">
                            <div class="col-12 p-0 bg-white">
                                <a href="{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}">
                                    <div class="media-wrapper-3x2">
                                        <img src="{{ App\Models\Base::getUploadURl($item->getThumbnail->name, $item->getThumbnail->dir) }}" class="img-cover" alt="{{ $item->name }}">
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 p-2">
                                <a href="{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}" class="premium-name">
                                    <span class="text-truncate">{{ $item->name }}</span>
                                </a>
                                <a href="{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}" class="premium-add" title="{{ $item->address.' '.$item->getCity->name.(!empty($item->route_guide) ? ' | '.$item->route_guide : '') }}">
                                    {{ $item->address.' '.$item->getCity->name.(!empty($item->route_guide) ? ' | '.$item->route_guide : '') }}
                                </a>
                            </div>
                            @if ($category_id == 0)
                                <div class="premium-tags col-12 p-2 border-top">
                                    <a href="{{ route('get_town_category_route', $item->getCategory->slug.'-'.$item->getCategory->id) }}" class="tag">{{ $item->getCategory->name }}</a>
                                </div>
                            @else
                                <div class="premium-tags col-12 p-2 border-top">
                                    @if($item->getTagList->count() > 0)
                                        @foreach ($item->getTagList as $tag)
                                            <a href="{{ route('get_town_tag_route', $tag->slug.'-'.$tag->id) }}" class="tag">{{ $tag->name }}</a>
                                        @endforeach
                                    @else
                                        <a href="{{ route('get_town_category_route', $item->getCategory->slug.'-'.$item->getCategory->id) }}" class="tag">{{ $item->getCategory->name }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="g-col-12 text-center">
                            <div class="alert alert-warning">
                                Now, we don't have any store in this category
                            </div>
                        </div>
                    @endforelse
                </div>
                {{-- End sponsored items  --}}

                {{-- pagination  --}}
                <div id="premium-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $town_list->links() }}
                    </nav>
                </div>
                {{--End  pagination  --}}

                {{-- free items  --}}
                {{-- <div id="free-items" class="nested x12 bg-grey border p-4 g-2">
                <div class="premium-item g-col-12 g-col-lg-6 border">
                <div class="col-3 p-0 bg-white">
                <a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium2.jpg') }}" class="img-cover"></div></a>
            </div>
            <div class="col-9 p-2">
            <a href="#" class="premium-name"><span class="text-truncate">Cafe Sule</span></a>
            <a href="#" class="premium-add" title="Sule Shangri-La | 223 Sule Pagoda Road, Yangon (Rangoon), Myanmar">Sule Shangri-La | 223 Sule Pagoda Road, Yangon (Rangoon), Myanmar</a>
        </div>
        <div class="premium-tags col-12 p-2 border-top">
        <a href="#" class="tag">Cafe</a>
        <a href="#" class="tag">Restaurant</a>
        <a href="#" class="tag">Breakfast</a>
    </div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium3.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Yangon Bakehouse</span></a>
<a href="#" class="premium-add" title="Kaba Aye Pagoda Road, Block C | Pearl Condo, Ground Floor, Yangon (Rangoon), Myanmar">Kaba Aye Pagoda Road, Block C | Pearl Condo, Ground Floor, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Cafe</a>
<a href="#" class="tag">Restaurant</a>
<a href="#" class="tag">Breakfast</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium4.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Novotel Yangon Max</span></a>
<a href="#" class="premium-add" title="459 Pyay Road | Kamayut Tsp, Yangon (Rangoon), Myanmar">459 Pyay Road | Kamayut Tsp, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Hotel</a>
<a href="#" class="tag">Luxury</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium5.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Savoy Hotel Yangon</span></a>
<a href="#" class="premium-add" title="129 Dhammazedi Road, Yangon (Rangoon), Myanmar">129 Dhammazedi Road, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Resort</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium6.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Melia Yangon</span></a>
<a href="#" class="premium-add" title="192 Kaba Aye Pagoda Road | Bahan Township, Yangon (Rangoon), Myanmar">192 Kaba Aye Pagoda Road | Bahan Township, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Hotel</a>
<a href="#" class="tag">Apartment</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium7.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Novotel Yangon Max</span></a>
<a href="#" class="premium-add" title="459 Pyay Road | Kamayut Tsp, Yangon (Rangoon), Myanmar">459 Pyay Road | Kamayut Tsp, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Cafe</a>
<a href="#" class="tag">Restaurant</a>
<a href="#" class="tag">Breakfast</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium8.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Savoy Hotel Yangon</span></a>
<a href="#" class="premium-add" title="129 Dhammazedi Road, Yangon (Rangoon), Myanmar">129 Dhammazedi Road, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Restaurant</a>
<a href="#" class="tag">Luxury</a>
</div>
</div>
<div class="premium-item g-col-12 g-col-lg-6 border">
<div class="col-3 p-0 bg-white">
<a href="#"><div class="media-wrapper-3x2"><img src="{{ asset('images/poste/demo/premium10.jpg') }}" class="img-cover"></div></a>
</div>
<div class="col-9 p-2">
<a href="#" class="premium-name"><span class="text-truncate">Shwe Sa Bwe</span></a>
<a href="#" class="premium-add" title="192 Kaba Aye Pagoda Road | Bahan Township, Yangon (Rangoon), Myanmar">20 Malikha Road Road | Mayangone, Yangon (Rangoon), Myanmar</a>
</div>
<div class="premium-tags col-12 p-2 border-top">
<a href="#" class="tag">Park</a>
<a href="#" class="tag">Golf</a>
</div>
</div> --}}
{{-- pagination  --}}
{{--  <div id="premium-pagination" class="g-col-12">
<nav aria-label="Page navigation example">
<ul class="pagination justify-content-center mb-0">
<li class="page-item disabled">
<a class="page-link" href="#" tabindex="-1">Previous</a>
</li>
<li class="page-item active"><a class="page-link" href="#">1</a></li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item">
<a class="page-link" href="#">Next</a>
</li>
</ul>
</nav>
</div> --}}
{{--End  pagination  --}}
</div>
{{--End  free items  --}}
</div>
{{-- End list of shops  --}}
</div>
</div>
{{-- End Main contents  --}}


{{-- mobile navigator --}}
<div class="premium-nav-mobile bg-grey d-flex d-lg-none flex-wrap accordion">
    @include('www.pages.town.mobile-navigator')
</div>
{{-- end mobile navigator --}}
@endsection
