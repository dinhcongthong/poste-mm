@extends('admin.layouts.master')

@section('stylesheets')
<style>
    #title-length {
        font-size: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id == 0 ? route('post_seo_meta_add_ad_route') : route('post_seo_meta_edit_ad_route', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
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
                <label>URL</label>
                <input type="url" class="form-control" value="{{ $article_url }}" name="article_url" required {{ $id != 0 ? 'readonly' : '' }}>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" value="{{ $title }}" name="title" required>
            </div>
            <div class="form-group">
                <label>Keywords</label>
                <input type="text" class="form-control" value="{{ $keywords }}" name="keywords" placeholder="key1,key2,..." required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="3" required>{{ $description }}</textarea>
            </div>
            <div class="form-group">
                <label>Image to Share on Social</small></label>
                <input type="url" class="form-control" value="{{ $image }}" name="image">
            </div>
            <div class="form-group">
                <label>Page Type</label>
                <select class="form-control" name="type" required>
                    <option value="article">Article</option>
                    <option value="website">Website</option>
                </select>
            </div>
            <div class="form-group text-center">
                <a class="mx-2 btn btn-outline-primary" href="{{ route('get_seo_meta_index_ad_route') }}">Back</a>
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
