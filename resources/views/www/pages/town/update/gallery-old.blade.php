<div class="p-4">
    <div id="gallery-errors">

    </div>
    <div class="d-grid x2 x4-md x4-lg g-4" id="general-list">
        <input type="hidden" name="general_list" value="">
        @foreach ($general_images as $item)
        <div id="gallery-item-{{ $item->id }}" class="gallery-item position-relative">
            <div class="media-wrapper-1x1">
                <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
                    <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                </a>
            </div>
            <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="{{ $item->id }}" data-section="4" style="bottom: 10px; right: 10px;">Delete</button>
        </div>
        @endforeach
    </div>
    <div class="w-100 text-center pt-4">
        <label for="general-upload" class="custom-input-file">
            Add General Image
        </label>
        <input id="general-upload" type="file" name="add_image_general[]" class="add-image-input" data-type="4" multiple>
    </div>
</div>
