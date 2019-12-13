<div class="p-4">
    <div class="d-grid x2 x4-md x4-lg g-4" id="general-list">
        @foreach ($general_images as $item)
        <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
            <div class="media-wrapper-1x1">
                <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" title="{{ $article->name }}" target="_blank">
                    <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
