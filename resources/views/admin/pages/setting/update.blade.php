@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id == 0 ? route('post_setting_add_ad_route') : route('post_setting_edit_ad_route', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">

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
                <input class="form-control" value="{{ $name }}" name="name" required>
            </div>
            <div class="form-group">
                <label>Value</label>
                <input class="form-control" value="{{ $value }}" name="value" required>
            </div>
            <div class="form-group">
                <label>English Value</label>
                <input class="form-control" value="{{ $english_value }}" name="english_value" placeholder=" (Option)">
            </div>
            <div class="form-group">
                <label>Tag</label>
                <select class="form-control select2" name="tag" required>
                    <option value="">Please choose a tag</option>
                    @foreach ($tagList as $item)
                    <option value="{{ $item->id }}" {{ $tag == $item->id ? 'selected' : '' }}>{{ $item->news_type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-center">
                <a class="mx-2 btn btn-outline-primary" href="{{ route('get_setting_index_ad_route') }}">Back</a>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

