@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ route('post_param_add_ad_route') }}" method="POST" enctype="multipart/form-data">
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
            <div class="form-group">
                <label>News Type</label>
                <div class="row no-gutters">
                    <input type="text" class="form-control col-12 col-sm-5" name="ip_news_type" value="{{ $ipNewsType }}">
                    <span class="col-12 col-sm-2 justify-content-center d-flex align-items-center"> Or </span>
                    <select class="form-control col-sm-5 select2" name="sl_news_type">
                        <option value="">Choose exists News Type</option>
                        @foreach ($newsTypeList as $item)
                        <option value="{{ $item }}" {{ $slNewsType == $item ? 'selected' : '' }}>{{ ucwords($item) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Tag Type</label>
                <div class="row no-gutters">
                    <input type="text" class="form-control col-12 col-sm-5" name="ip_tag_type" value="{{ $ipTagType }}">
                    <span class="col-12 col-sm-2 justify-content-center d-flex align-items-center"> Or </span>
                    <select class="form-control col-sm-5 select2" name="sl_tag_type">
                        <option value="">Choose exists Tag Type</option>
                        @foreach ($tagTypeList as $item)
                        <option value="{{ $item }}" {{ $slTagType == $item ? 'selected' : '' }}>{{ ucwords($item) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group text-center">
                <a href="{{ route('get_param_index_ad_route') }}" class="btn btn-outline-primary">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
