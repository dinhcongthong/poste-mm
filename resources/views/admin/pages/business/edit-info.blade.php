@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 py-2">
        <form action="{{ route('post_business_edit_info', $business_item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 w-100">
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Name</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="name" value="{{ $business_item->name }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Article Type</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <select class="form-control" name="type">
                        <option value="0" {{ $business_item->fee == 0 ? 'selected' : '' }}>Free</option>
                        <option value="1" {{ $business_item->fee == 1 ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>
            </div>
            <div class="form-group row {{ $business_item->fee == 0 ? '' : 'd-none' }}" id="end-free-date-form">
                <label class="col-12 col-sm-2 col-form-label text-right">End Free Date</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="end_free_date" value="{{ $business_item->end_free_date }}">
                </div>
            </div>
            <div class="form-group row {{ $business_item->fee == 1 ? '' : 'd-none' }}" id="start-date-form">
                <label class="col-12 col-sm-2 col-form-label text-right">Start Contract Date</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="start_date" value="{{ $business_item->start_date }}">
                </div>
            </div>
            <div class="form-group row {{ $business_item->fee == 1 ? '' : 'd-none' }}" id="end-date-form">
                <label class="col-12 col-sm-2 col-form-label text-right">End Contract Date</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="end_date" value="{{ $business_item->end_date }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <button type="submit" class="btn btn-primary m-auto">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
