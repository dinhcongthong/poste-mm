@forelse($promotionList as $item)
@php
$categoryList = $item->getCategoryNews->pluck('category_id')->toArray();
@endphp
<a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}" class="{{ in_array(5, $categoryList) ? 'promo-item' : 'event-item' }} nav-link text-dark p-0">
    <div class="col-5 col-lg-3 p-0 bg-light">
        <img src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" class="img-cover" alt="{{ $item->name }}">
    </div>
    <div class="col p-3 caption">
        <h2 class="mb-3">
            {{ $item->name }}
            <span class="badge badge-secondary">{{ date('m月d日', strtotime($item->published_at)) }}</span>
            @if($item->datecount < 4)
            <span class="badge badge-danger">NEW</span>
            @endif
        </h2>
        <p class="d-none d-lg-block">
            {{ $item->description }}
        </p>
    </div>
</a>
@empty
<h2 class="text-center">No Data</h2>
@endforelse
<a href="{{ route('get_dailyinfo_category_route', 'promotion-5') }}" class="top-side-M view-all" title="もっと見る" style="top: 1px; color: #26255f">
    <p class="view-all-ico d-none d-lg-inline-block">もっと見る </p>
    <i class="fa fa-list view-all-ico" aria-hidden="true"></i>
</a>
