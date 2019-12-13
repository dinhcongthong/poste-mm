@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id != 0 ? route('post_ads_edit_ad_route', ['id' => $id]) : route('post_ads_add_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" />
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 w-100">
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="description" value="{{ $description }}" required>
            </div>
            <div class="form-group">
                <label>Customer</label>
                <div class="row">
                    <div class="col-12 col-sm-8 mb-1">
                        <select class="form-control select2" id="sl-choose-customer" name="customer_id" required>
                            <option value="">Please choose customer</option>
                            @foreach ($customerList as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $customerId ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 mb-1">
                        <button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#modalAddCustomer">Add New Customer</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-1">
                        <label>Position</label>
                        <select class="select2 form-control" name="position_id" required>
                            <option value="">Please choose Position</option>
                            @foreach ($positionList as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $positionId ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <label>City</label>
                        <select class="select2 form-control" name="city_id" required>
                            <option value="">Please choose City</option>
                            @foreach ($cityList as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $cityId ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>UTM Campaign</label>
                <input type="text" class="form-control" placeholder="Please type alphabets only" name="utm_campaign" value="{{ $utmCampaign }}" required {{ $id != 0 ? 'readonly' : '' }}>
            </div>
            <div class="form-group">
                <label>Image</label>
                <div class="row">
                    <div class="col-12 col-sm-7 mb-1">
                        <input type="text" class="form-control" placeholder="optional" name="ip_url_image" value="{{ $imageURL }}" readonly>
                    </div>
                    <div class="col-12 col-sm-5 mb-1 d-flex align-items-center">
                        <input type="file" name="ip_image" data-max-size="6">
                    </div>
                    <div class="col-12">
                        <small>
                            <i>
                                Supported extensions: jpg, jpeg, gif, png<br/>
                                Size limit: 6 MB
                            </i>
                        </small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Link</label>
                <input type="url" class="form-control" name="link" value="{{ $link }}" required>
            </div>
            <div class="form-group">
                <label>Schedule</label>
                <div class="row">
                    <div class="col-12 col-sm-6 mb-1">
                        <input type="text" class="form-control" id="start-date" name="start_date" placeholder="Start Date" value="{{ $startDate }}" readonly>
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <input type="text" class="form-control" id="end-date" name="end_date" placeholder="End Date" value="{{ $endDate }}" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control" rows="3" id="note" name="note">{{ $note }}</textarea>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12 mb-1 col-sm-6">
                        <label>Status</label>
                        <select class="form-control select2-no-search" name="status" required>
                            <option value="1" {{ $status ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ !$status ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <a class="mx-1 btn btn-outline-primary" href="{{ route('get_ads_index_ad_route') }}">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@include('admin.includes.customer-add-modal')
@endsection
