@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 py-2">
        <form action="{{ $id != 0 ? route('post_theater_edit_ad_route', ['id' => $id]) : route('post_theater_add_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <input type="hidden" name="id" value="{{ $id }}">
            
            <div class="card">
                <h5 class="card-header">Branch</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" value="{{ $name }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-7">
                            <div class="form-group">
                                <label>Image</label>
                                <div class="row">
                                    <div class="col-12 col-sm-8">
                                        <input class="form-control" name="thumb_url" value="{{ $thumbURL }}" readonly>
                                    </div>
                                    <div class="col-12 col-sm-4 d-flex align-items-center">
                                        <input type="file" name="thumb">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="description">{{ $description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            <div class="row mt-3">
                <div class="col-12">
                    <h4>Position Theaters</h4>
                </div>
                <div class="col-12" id="position-list">
                    @foreach ($positionList as $item)
                    <div class="form-group row position-item" id="position-item-{{ $loop->index + 1 }}">
                        <input type="hidden" name="position_id[]" value="{{ $item->id }}">
                        <div class="col-12 col-sm-2">
                            <label>Name</label>
                            <input class="form-control" name="position_name[]" value="{{ $item->name }}" placeholder="Name" required>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>City</label>
                            <select class="form-control select2" name="city_id[]" id="city-select-{{ $loop->index + 1 }}" required>
                                <option value="">Choose City</option>
                                @foreach ($cityList as $city)
                                <option value="{{ $city->id }}" {{ $item->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>District</label>
                            <select class="form-control select2" name="district_id[]" id="district-select-{{ $loop->index + 1 }}">
                                @foreach($districtList as $district) 
                                @if($district->city_id == $item->city_id) 
                                <option value="{{ $district->id }}" {{ $district->id == $item->district_id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label>Address</label>
                            <input class="form-control" name="position_address[]" value="{{ $item->address }}" placeholder="Address" required>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>Status</label>
                            <select class="select2-no-search form-control" id="status-select-{{ $loop->index }}">
                                <option value="1" {{ !$item->trashed() ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ $item->trashed() ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-1 text-center d-flex align-items-end">
                            <button class="btn-delete btn btn-danger align-bottom" type="button" data-item="{{ $loop->index + 1 }}" data-id="{{ $item->id }}"><i class="fas fa-times-circle"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-12">
                    <button class="btn btn-success btn-add-position" type="button">Add More Position</button>
                </div>
            </div>
            
            <div class="row mt-3 justify-content-center">
                <a class="btn btn-outline-primary mx-2" href="{{ route('get_theater_index_ad_route') }}">Back</a>
                <button class="btn btn-primary mx-2" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection