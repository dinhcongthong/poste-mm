<h5 class="text-danger fw-bolder text-center">{{ $business_item->name }}</h5>
<div class="row">
    <div class="col-4">
        <img src="{{ App\Models\Base::getUploadURL($business_item->getThumb->name, $business_item->getThumb->dir) }}" class="img-fluid">
    </div>
    <div class="col">
        <p>
            {{ $business_item->description }}
        </p>
    </div>
</div>
