<div class="row" id="map-list">
    <div class="col-12 col-md-6 mb-4">
        <form id="primary-map-form">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Primary Address
                </div>
                <div class="card-body">
                    <input class="form-control mb-2" name="address" placeholder="Address" value="{{ $address }}">
                    <input class="form-control mb-2" name="map" placeholder="Google Map Embeded Code" value="{{ $map }}">
                    <textarea placeholder="Route Guide" rows="5" name="route_guide" class="form-control mb-4">{{ nl2br($route_guide) }}</textarea>
                    <p class="font-weight-bold">Image</p>
                    <div class="w-100 text-center mb-2 img-route-guide-preview">
                        <img class="img-responsive mh-100 m-auto img-map-preview" alt="Primary map Image" src="{{ empty($img_route_guide_url) ? asset('images/poste/no-image-6x4.png') : $img_route_guide_url }}">
                    </div>
                    {{-- <input type="hidden" name="image_route_guide_url" value="{{ empty($img_route_guide) ? '' : $img_route_guide }}"> --}}
                    <input type="file" name="image_route_guide" id="input-primary-img">
                </div>
            </div>
        </form>
    </div>
    @foreach ($map_list as $item)
    <div class="col-12 col-md-6 mb-4" id="map-more-{{ $loop->iteration }}">
        <form class="map-more-form" data-count="{{ $loop->iteration }}">
            <input type="hidden" name="branch_id" value="{{ $item->id }}">
            <div class="card">
                <div class="card-body">
                    <input class="form-control mb-2" name="address" placeholder="Address" value="{{ $item->address }}">
                    <input class="form-control mb-2" name="map" placeholder="Google Map Embeded Code" value="{{ $item->map }}">
                    <textarea placeholder="Route Guide" rows="5" name="route_guide" class="form-control mb-4">{{ nl2br($item->route_guide) }}</textarea>
                    <p class="font-weight-bold">Image</p>
                    <div class="w-100 text-center mb-2 img-route-guide-preview">
                        <img class="img-responsive mh-100 m-auto img-map-preview" alt="{{ $item->id}}" src="{{ !empty($item->getImage) ? App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) : asset('images/poste/no-image-6x4.png') }}">
                    </div>
                    <input type="hidden" name="img_route_guide_url" value="{{ empty($item->getImage) ? '' : App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}">
                    <input type="file" name="image_route_guide" data-count="{{ $loop->iteration }}">
                </div>
                <div class="card-footer">
                    <a href="#" class="text-danger float-right btn-delete-map" data-count="{{ $loop->iteration }}">Delete</a>
                </div>
            </div>
        </form>
    </div>
    @endforeach
</div>
<div class="divider mb-4"></div>
<div class="btn-area">
    <button class="btn btn-primary" data-count="{{ count($map_list) }}" id="add-map-more" type="button">Add More</button>
</div>
