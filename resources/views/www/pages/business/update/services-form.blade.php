<div id="service-list" class="d-grid g-4">
    @forelse ($service_list as $item)
    <div class="service-item" id="service-item-{{ $loop->iteration }}">
        <form class="business-service-form" id="bs_service_form">
            <input type="hidden" name="service_id" value="{{ $item->id }}">
            <input placeholder="Service Name" name="service_name" value="{{ $item->name }}" class="form-control mb-3">
            <textarea class="form-control" name="service_description" placeholder="Service Description">{!! nl2br($item->description) !!}</textarea>
            <br/>
            <a href="#" class="float-right text-danger btn-delete-service" data-count="{{ $loop->iteration}}">Delete</a>
        </form>
    </div>
    @empty
    <p id="service-nothing" class="g-col-2 g-col-md-4 g-col-lg-8 m-0 text-center mb-0">No Data</p>
    @endforelse
</div>
<div class="divider my-4"></div>
<div class="btn-area">
    <button class="btn btn-primary btn-add-service" id="btn-add-service" data-count="{{ count($service_list) }}" type="button">Add More</button>
</div>
