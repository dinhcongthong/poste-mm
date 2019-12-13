<div class="row" id="related-list">
    @forelse ($relate_list as $item)
    <div class="col-12 col-md-6 mb-4 realted-item" id="related-item-{{ $loop->iteration }}">
        <form class="related-form">
            <div class="card">
                <input type="hidden" name="related_id" value="{{ $item->id }}">
                <div class="card-header">
                    <input type="text" placeholder="Business Name" name="related_name" value="{{ $item->name }}" class="form-control">
                </div>
                <div class="card-body">
                    <div>
                        <label class="label-form-control">Address</label>
                        <input type="text" class="form-control mb-2" name="related_address" value="{{ $item->address }}">
                    </div>
                    <div>
                        <label class="label-form-control">Phone</label>
                        <input type="text" class="form-control mb-2" name="related_phone" value="{{ $item->phone }}">
                    </div>
                    <div>
                        <label class="label-form-control">Email</label>
                        <input type="text" class="form-control mb-2" name="related_email" value="{{ $item->email }}">
                    </div>
                    <div>
                        <label class="label-form-control">Website</label>
                        <input type="text" class="form-control" name="related_website" value="{{ $item->website }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger float-right btn-delete-related" data-count="{{ $loop->iteration }}">Delete</button>
                </div>
            </div>
        </form>
    </div>
    @empty
    <p id="relate-nothing" class="col-12 text-center">No Data</p>
    @endforelse
</div>
<div class="divider mb-4"></div>
<div class="btn-area">
    <button class="btn btn-primary" id="add-related-more" type="button" data-count="{{ count($relate_list) }}">Add More</button>
</div>
