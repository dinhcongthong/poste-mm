<div class="col-12 d-flex flex-wrap px-0 showtime-item py-2" id="showtime-item-{{ $showtimeCount }}">
    <input type="hidden" name="showtime_ids[]" value="0">
    <div class="col-12 col-sm-3">
        <select class="form-control select2-no-search" name="branch[]" required>
            <option value="">Please choose Theater</option>
            @foreach ($theaterList as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <select class="form-control select2-no-search" name="position_ids[]" required>
            <option value="">Please choose Position</option>
        </select>
    </div>
    <div class="col-12 col-sm-2">
        <input class="form-control datepicker" name="show_dates[]" placeholder="Showtime Date" required>
    </div>
    <div class="col-12 col-sm-3">
        <input class="form-control" name="show_hours[]" placeholder="Showtime Hours" required>
    </div>
    <div class="col-12 col-sm-1 text-center">
        <button class="delete-showtime btn btn-danger" data-showtime-count="{{ $showtimeCount }}" type="button">
            <i class="fas fa-times-circle"></i>
        </button>
    </div>
</div>