<div id="detail-gallery-list" class="d-grid x6-lg x2 x4-md g-4">
    @foreach ($business_galleries as $item)
    <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
        <div class="media-wrapper-1x1">
            <a href="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" title="{{ $business_item->name }}" target="_blank">
                <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}">
            </a>
        </div>
    </div>
    @endforeach
</div>
@if($business_galleries->currentPage() < $business_galleries->lastPage())
<div class="text-center g-col-6 pt-4">
    <button type="button" class="btn btn-info rounded-pill" data-id="{{ $business_item->id }}" data-name="{{ $business_item->name }}" data-page="{{ $business_galleries->currentPage() }}" id="load-more-images">Load more...</button>
</div>
@endif
