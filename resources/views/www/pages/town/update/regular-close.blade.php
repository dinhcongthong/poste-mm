<form id="regular-close-form">
    <div id="regular-close-section">
        @forelse ($regular_list as $item)    
        <div class="regular-close-item" data-count="{{ $loop->iteration }}">
            <div class="row">
                <input type="hidden" value="{{ $item->id }}" name="id[]">
                <div class="col-12 col-md-3">
                    <input type="text" class="form-control datepicker" name="start_date[]" value="{{ date('m-d-Y', strtotime($item->start_date)) }}" placeholder="Start Date" required>
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" class="form-control datepicker" name="end_date[]" value="{{ date('m-d-Y', strtotime($item->end_date)) }}" placeholder="End Date" required>
                </div>
                <div class="col-12 col-md-5">
                    <input type="text" class="form-control" name="note[]" value="{{ $item->note }}" placeholder="Note">
                </div>
                <div class="col-12 col-md">
                    <button class="btn btn-danger delete-regular" type="button" title="Remove" data-count="{{ $loop->iteration }}">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
         <div class="regular-close-item" data-count="1">
            <div class="row">
                <input type="hidden" value="0" name="id[]">
                <div class="col-12 col-md-3">
                    <input type="text" class="form-control datepicker" name="start_date[]" value="" placeholder="Start Date" required>
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" class="form-control datepicker" name="end_date[]" value="" placeholder="End Date" required>
                </div>
                <div class="col-12 col-md-5">
                    <input type="text" class="form-control" name="note[]" value="" placeholder="Note">
                </div>
                <div class="col-12 col-md">
                    <button class="btn btn-danger delete-regular" type="button" title="Remove" data-count="1">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <button class="btn btn-success mt-3" type="button" id="add-regular-close" data-count="{{ count($regular_list) > 0 ? count($regular_list) : '1' }}">Add One</button>
</form>