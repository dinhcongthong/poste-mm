@foreach ($showtimeList as $item)
@php 
$branchId = $item->getPositionTheater->getParentTheater->id;
$positionList = [];
@endphp
<div class="col-12 d-flex flex-wrap px-0 showtime-item py-2" id="showtime-item-{{ $loop->index + 1 }}">
    <input type="hidden" name="showtime_ids[]" value="{{ $item->id }}">
    <div class="col-12 col-sm-3">
        <select class="form-control select2-no-search" name="branch[]" required>
            <option value="">Please choose Theater</option>
            @foreach ($theaterList as $theater)
            <option value="{{ $theater->id }}" {{ $branchId == $theater->id ? 'selected' : '' }}>{{ $theater->name }}</option>
            @php
            if($branchId == $theater->id) {
                $positionList = $theater->getChildTheater;
            }
            @endphp
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-3">
        <select class="form-control select2-no-search" name="position_ids[]" required>
            <option value="">Please choose Position</option>
            @foreach ($positionList as $position)
            <option value="{{ $position->id }}" {{ $position->id == $item->position_id ? 'selected' : '' }}>{{ $position->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-2">
        <input class="form-control datepicker" name="show_dates[]" placeholder="Showtime Date" value="{{ date('m-d-Y', strtotime($item->show_date)) }}" required>
    </div>
    <div class="col-12 col-sm-3">
        <input class="form-control" name="show_hours[]" placeholder="Ex: 03:30,10:15,12:00,15:30,19:00" value="{{ $item->show_hours }}" required>
    </div>
    <div class="col-12 col-sm-1 text-center">
        <button class="delete-showtime btn btn-danger" data-showtime-count="{{ $loop->index + 1 }}" type="button">
            <i class="fas fa-times-circle"></i>
        </button>
    </div>
</div>
@endforeach