<div class="w-100 text-center">
    Maximun of image number: <span class="text-danger">100 images</span><br/>
    Best image size: <span class="text-danger">W: 900px ~ 1200px - H: 900px ~ 1200px</span><br/>
    Supported File type: <span class="text-danger">jpg, jpeg, png, svg, gif, bmp</span><br/>
    Max each file size: <span class="text-danger">2MB</span><br/>
</div>
<div class="p-3 p-lg-4 d-grid x2 x4-lg g-3">
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#space-tab" id="ga-space" class="text-dark">
        <input type="hidden" name="space_gallery_ids" value="">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                <img src="{{ asset('images/poste/add.png') }}" class="img-cover" style="border: 1px solid #d6d4d4;">
            </div>
        </div>
        <strong>Space</strong>
        <small class="text-secondary"><span id="space-count">{{ count($space_images) }}</span> photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#food-tab" id="ga-food" class="text-dark">
        <input type="hidden" name="food_gallery_ids" value="">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                <img src="{{ asset('images/poste/add.png') }}" class="img-cover" style="border: 1px solid #d6d4d4;">
            </div>
        </div>
        <strong>Food</strong>
        <small class="text-secondary"><span id="food-count">{{ count($food_images) }}</span> photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#menu-tab" id="ga-menu" class="text-dark">
        <input type="hidden" name="menu_gallery_ids" value="">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                <img src="{{ asset('images/poste/add.png') }}" class="img-cover" style="border: 1px solid #d6d4d4;">
            </div>
        </div>
        <strong>Menu</strong>
        <small class="text-secondary"><span id="menu-count">{{ count($menu_images) }}</span> photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#general-tab" id="ga-general" class="text-dark">
        <input type="hidden" name="general_gallery_ids" value="">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                <img src="{{ asset('images/poste/add.png') }}" class="img-cover" style="border: 1px solid #d6d4d4;">
            </div>
        </div>
        <strong>General</strong>
        <small class="text-secondary"><span id="general-count">{{ count($general_images) }}</span> photos</small>
    </a>
</div>

<div class="modal fade" id="gallerybox" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Albums</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="space-tab" data-toggle="tab" href="#space-panel" role="tab" aria-controls="space-panel" aria-selected="false">Space</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="food-tab" data-toggle="tab" href="#food-panel" role="tab" aria-controls="food-panel" aria-selected="false">Food</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="menu-tab" data-toggle="tab" href="#menu-panel" role="tab" aria-controls="menu-panel" aria-selected="false">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="general-tab" data-toggle="tab" href="#general-panel" role="tab" aria-controls="general-panel" aria-selected="false">General</a>
                    </li>
                </ul>
                <div class="row d-none" id="gallery-errors">
                </div>
                <div class="tab-content" id="myTabContent">
                    <input type="hidden" name="space_list">
                    <input type="hidden" name="food_list">
                    <input type="hidden" name="menu_list">
                    <input type="hidden" name="general_list">
                    @php
                    $image_total = count($space_images) + count($food_images) + count($menu_images) + count($general_images);
                    @endphp
                    <div class="tab-pane fade active show" id="space-panel" role="tabpanel" aria-labelledby="space-tab">
                        <div class="w-100 text-center btn-add-area {{ $image_total < 100 ? '' : 'd-none' }}" id="btn-add-area-space">
                            <label for="space-upload" class="custom-input-file">
                                Add Space Image
                            </label>
                            <input id="space-upload" type="file" name="add_image_space[]" class="add-image-input" data-type="{{ App\Models\TownGallery::TYPE_SPACE }}" multiple>
                        </div>
                        <div class="d-grid x2 x4-md x7-lg g-4" id="space-list">
                            @foreach ($space_images as $item)
                            <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
                                <div class="media-wrapper-1x1">
                                    <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
                                        <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                                    </a>
                                </div>
                                <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="{{ $item->id }}" data-section="{{ App\Models\TownGallery::TYPE_SPACE }}" style="bottom: 10px; right: 10px;">Delete</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="food-panel" role="tabpanel" aria-labelledby="food-tab">
                        <div class="w-100 text-center btn-add-area {{ $image_total < 100 ? '' : 'd-none' }}" id="btn-add-area-food">
                            <label for="food-upload" class="custom-input-file">
                                Add Food Image
                            </label>
                            <input id="food-upload" type="file" name="add_image_food[]" class="add-image-input" data-type="{{ App\Models\TownGallery::TYPE_FOOD }}" multiple>
                        </div>
                        <div class="d-grid x2 x4-md x7-lg g-4" id="food-list">
                            @foreach ($food_images as $item)
                            <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
                                <div class="media-wrapper-1x1">
                                    <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
                                        <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                                    </a>
                                </div>
                                <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="{{ $item->id }}" data-section="{{ App\Models\TownGallery::TYPE_FOOD }}" style="bottom: 10px; right: 10px;">Delete</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="menu-panel" role="tabpanel" aria-labelledby="menu-tab">
                        <div class="w-100 text-center btn-add-area {{ $image_total < 100 ? '' : 'd-none' }}" id="btn-add-area-menu">
                            <label for="menu-upload" class="custom-input-file">
                                Add Menu Image
                            </label>
                            <input id="menu-upload" type="file" name="add_image_menu[]" class="add-image-input" data-type="{{ App\Models\TownGallery::TYPE_MENU }}" multiple>
                        </div>
                        <div class="d-grid x2 x4-md x7-lg g-4" id="menu-gallery-list">
                            @foreach ($menu_images as $item)
                            <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
                                <div class="media-wrapper-1x1">
                                    <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
                                        <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                                    </a>
                                </div>
                                <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="{{ $item->id }}" data-section="{{ App\Models\TownGallery::TYPE_MENU }}" style="bottom: 10px; right: 10px;">Delete</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="general-panel" role="tabpanel" aria-labelledby="general-tab">
                        <div class="w-100 text-center btn-add-area {{ $image_total < 100 ? '' : 'd-none' }}"  id="btn-add-area-general">
                            <label for="general-upload" class="custom-input-file">
                                Add General Image
                            </label>
                            <input id="general-upload" type="file" name="add_image_general[]" class="add-image-input" data-type="{{ App\Models\TownGallery::TYPE_GENERAL }}" multiple>
                        </div>
                        <div class="d-grid x2 x4-md x7-lg g-4" id="general-list">
                            @foreach ($general_images as $item)
                            <div id="gallery-item-{{$item->id}}" class="gallery-item position-relative">
                                <div class="media-wrapper-1x1">
                                    <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
                                        <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                                    </a>
                                </div>
                                <button type="button" class="btn btn-danger position-absolute delete-gallery" data-id="{{ $item->id }}" data-section="{{ App\Models\TownGallery::TYPE_GENERAL }}" style="bottom: 10px; right: 10px;">Delete</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
