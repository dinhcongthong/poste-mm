@php
$monday = explode('-', $monday);
$tuesday = explode('-', $tuesday);
$wednessday = explode('-', $wednessday);
$thursday = explode('-', $thursday);
$friday = explode('-', $friday);
$saturday = explode('-', $saturday);
$sunday = explode('-', $sunday);

$open_hours = [];
$close_hours = [];
@endphp

<div id="working-time-errrors">

</div>

<form id="working-time-form">
    <div class="d-grid x2-lg g-3 g-lg-4">
        <div class="working-time-item">
            <h6 class="font-weight-bold">
                Monday
            </h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="0">
                        <option value="1" {{ !empty($monday) && $monday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($monday) && $monday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                @php
                if(!empty($monday)) {
                    if(!empty($monday[1])) {
                        $open_hours = explode(',', $monday[1]);
                    }
                    if(!empty($monday[2])) {
                        $close_hours = explode(',', $monday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="0" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="0" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="0" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="0" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($monday); $i++) {
                        if($i == 3) {
                            $note = $monday[$i];
                        } else {
                            $note .= '-'.$monday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Tuesday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="1">
                        <option value="1" {{ !empty($tuesday) && $tuesday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($tuesday) && $tuesday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                @php
                if(!empty($tuesday)) {
                    if(!empty($tuesday[1])) {
                        $open_hours = explode(',', $tuesday[1]);
                    }
                    if(!empty($tuesday[2])) {
                        $close_hours = explode(',', $tuesday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="1" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="1" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="1" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="1" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($tuesday); $i++) {
                        if($i == 3) {
                            $note = $tuesday[$i];
                        } else {
                            $note .= '-'.$tuesday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Wednessday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="2">
                        <option value="1" {{ !empty($wednessday) && $wednessday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($wednessday) && $wednessday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                 @php
                if(!empty($wednessday)) {
                    if(!empty($wednessday[1])) {
                        $open_hours = explode(',', $wednessday[1]);
                    }
                    if(!empty($wednessday[2])) {
                        $close_hours = explode(',', $wednessday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="2" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="2" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="2" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="2" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($wednessday); $i++) {
                        if($i == 3) {
                            $note = $wednessday[$i];
                        } else {
                            $note .= '-'.$wednessday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Thursday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="3">
                        <option value="1" {{ !empty($thursday) && $thursday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($thursday) && $thursday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                 @php
                if(!empty($thursday)) {
                    if(!empty($thursday[1])) {
                        $open_hours = explode(',', $thursday[1]);
                    }
                    if(!empty($thursday[2])) {
                        $close_hours = explode(',', $thursday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="3" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="3" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="3" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="3" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($thursday); $i++) {
                        if($i == 3) {
                            $note = $thursday[$i];
                        } else {
                            $note .= '-'.$thursday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Friday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="4">
                        <option value="1" {{ !empty($friday) && $friday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($friday) && $friday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                 @php
                if(!empty($friday)) {
                    if(!empty($friday[1])) {
                        $open_hours = explode(',', $friday[1]);
                    }
                    if(!empty($friday[2])) {
                        $close_hours = explode(',', $friday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="4" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="4" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="4" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="4" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($friday); $i++) {
                        if($i == 3) {
                            $note = $friday[$i];
                        } else {
                            $note .= '-'.$friday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Saturday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="5">
                        <option value="1" {{ !empty($saturday) && $saturday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($saturday) && $saturday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                 @php
                if(!empty($saturday)) {
                    if(!empty($saturday[1])) {
                        $open_hours = explode(',', $saturday[1]);
                    }
                    if(!empty($saturday[2])) {
                        $close_hours = explode(',', $saturday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="5" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="5" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="5" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="5" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($saturday); $i++) {
                        if($i == 3) {
                            $note = $saturday[$i];
                        } else {
                            $note .= '-'.$saturday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
        <div class="working-time-item">
            <h6 class="font-weight-bold">Sunday</h6>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-control" name="status_working_time[]" data-count="6">
                        <option value="1" {{ !empty($sunday) && $sunday[0] == 1 ? 'selected' : '' }}>Open</option>
                        <option value="0" {{ !empty($sunday) && $sunday[0] == 0 ? 'selected' : '' }}>Close</option>
                    </select>
                </div>
                 @php
                if(!empty($sunday)) {
                    if(!empty($sunday[1])) {
                        $open_hours = explode(',', $sunday[1]);
                    }
                    if(!empty($sunday[2])) {
                        $close_hours = explode(',', $sunday[2]);
                    }
                }
                @endphp
                <div class="col-6 mb-4">
                    <input name="working_time_open[]" class="form-control time-picker" placeholder="Open Time" data-count="6" value="{{ count($open_hours) >= 1 ? $open_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close[]" class="form-control time-picker" placeholder="Close Time" data-count="6" value="{{ count($close_hours) >= 1 ? $close_hours[0] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_open1[]" class="form-control time-picker" placeholder="Open Time 1 (Option)" data-count="6" value="{{ count($open_hours) > 1 ? $open_hours[1] : '' }}">
                </div>
                <div class="col-6 mb-4">
                    <input name="working_time_close1[]" class="form-control time-picker" placeholder="Close Time 1 (Option)" data-count="6" value="{{ count($close_hours) > 1 ? $close_hours[1] : '' }}">
                </div>
                <div class="col-12">
                    @php
                    $note = '';
                    for($i = 3; $i < count($sunday); $i++) {
                        if($i == 3) {
                            $note = $sunday[$i];
                        } else {
                            $note .= '-'.$sunday[$i];
                        }
                    }
                    @endphp
                    <input type="text" class="form-control" name="working_time_note[]" placeholder="Note (Option)" value="{{ $note }}">
                </div>
            </div>
        </div>
    </div>
</form>
