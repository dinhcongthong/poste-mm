<div class="form-group row position-item" id="position-item-{{ $positionNumber }}">
    <input type="hidden" name="position_id[]" value="0">
    <div class="col-12 col-sm-2">
        <label>Name</label>
        <input class="form-control" name="position_name[]" value="" placeholder="Name" required>
    </div>
    <div class="col-12 col-sm-2">
        <label>City</label>
        <select class="form-control select2" name="city_id[]" id="city-select-{{ $positionNumber }}" required>
            <option value="">Choose City</option>
            @foreach ($cityList as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-2">
        <label>District</label>
        <select class="form-control select2" name="district_id[]" id="district-select-{{ $positionNumber }}">
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <label>Address</label>
        <input class="form-control" name="position_address[]" value="" placeholder="Address" required>
    </div>
    <div class="col-12 col-sm-2">
        <label>Status</label>
        <select class="select2 form-control" id="status-select-{{ $positionNumber }}">
            <option value="1">Published</option>
            <option value="0">Pending</option>
        </select>
    </div>
    <div class="col-12 col-sm-1 text-center d-flex align-items-end">
        <button class="btn-delete btn btn-danger align-bottom" type="button" data-item="{{ $positionNumber }}" data-id="0"><i class="fas fa-times-circle"></i></button>
    </div>
</div>