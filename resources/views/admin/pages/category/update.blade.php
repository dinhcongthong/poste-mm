@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id != 0 ? route('post_category_edit_ad_route', ['id' => $id]) : route('post_category_add_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="id" value="{{ $id }}">

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
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $name }}" required>
            </div>
            <div class="form-group">
                <label for="name">English Name</label>
                <input type="text" id="english-name" class="form-control" name="english_name" value="{{ $english_name }}" placeholder="(Option)">
            </div>
            <div class="form-group">
                <label for="slug">Slug <small class="text-danger font-italic">(Option)</small></label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ $slug }}">
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label for="original-name">Original Name</label>
                        <select class="form-control select2-no-search" name="tag" required>
                            <option value="">Choose</option>
                            @foreach($galleryTags as $item)
                            <option value="{{ strtolower($item->id) }}" {{ $item->id == $tag ? 'selected' : ''}}>{{ ucfirst($item->news_type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="original-name" style="height: 1.06rem;"></label>
                        <select class="form-control select2-no-search" name="original_type">
                            <option value="category">Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="oder-num">Order Number <small class="text-danger font-italic">(Option)</small></label>
                <input type="number" id="oder-num" class="form-control" name="order_num" value="{{ $orderNum }}">
            </div>
            <div class="form-group">
                <label for="oder-num">Icon <small class="text-danger font-italic">(Option)</small></label>
                <div class="row m-0 align-items-center">
                    <input type="text" class="form-control col-12 col-sm-8" name="icon_url" value="{{ $icon }}" readonly>
                    <input type="file" class="col-12 col-sm-4" name="icon">
                    <p class="font-italic pt-1">
                        <b>Image type: </b> jpeg, png, jpg, svg<br/>
                        <b>Image Max size: </b> 2MB.<br/>
                        <b>Image Dimension ratio: </b> 1:1
                    </p>
                </div>
            </div>
            <div class="form-group text-center">
                <a class="btn btn-outline-primary mx-2" href="{{ route('get_category_index_ad_route') }}">Back</a>
                <button class="btn btn-primary mx-2" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@stop
