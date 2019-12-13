@foreach ($galleries as $item)
<div class="col-12 mb-3" id="pre-img-{{ $item->id }}">
    <div class="w-100">
        <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
    </div>
    <a class="btn-delete-golf-img float-right" href="#" data-id="{{ $item->id }}">Delete</a>
    <div class="clearfix"></div>
</div>
@endforeach