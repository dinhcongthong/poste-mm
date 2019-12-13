<h2 class="m-0">イメージ</h2>
<div class="divider mb-4"></div>
<div id="gallery-error-show">
</div>
<div id="gallery-list" class="d-grid x6-lg x2 x4-md g-4">
    @forelse ($gallery_list as $item)
        <div id="gallery-item-{{ $item->id }}" class="gallery-item position-relative">
            <input type="hidden" name="gallery_ids[]" value="{{ $item->id }}">
            <div class="media-wrapper-1x1">
                <a href="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" target="_blank">
                    <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}">
                </a>
            </div>
            <button type="button" class="btn btn-danger position-absolute delete-gallery"  style="bottom: 10px; right: 10px;" data-id="{{ $item->id }}">Delete</button>
        </div>
    @empty
        <p class="g-col-2 g-col-md-4 g-col-lg-8 m-0 text-center" id="gallery-nothing">No Data In Gallery</p>
    @endforelse
</div>
<div class="divider my-4"></div>
<div class="btn-area">
    <div class="w-100 text-center" id="btn-add-gallery-area">
        <label for="general-upload" class="custom-input-file">
            Add More
        </label>
        <input id="general-upload" type="file" name="add_image[]" class="add-image-input" multiple>
    </div>
    <p class="text-center text-danger">
        ** File types: <span class="font-weight-bold">jpg, png, gif, jpeg</span> **<br/>
        ** Max size: <span class="font-weight-bold">2MB</span> **<br/>
        ** Min width: <span class="font-weight-bold">400px</span> **<br/>
        ** Max image number: <span class="font-weight-bold">100 images</span> **
    </p>
</div>
