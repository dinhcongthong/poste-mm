@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <div class="col-12 col-sm-10 mb-2">
        <form action="{{ route('get_gallery_index_ad_route') }}" method="GET" class="row">
            <div class="col-12 col-sm-2 mb-1">
                <input class="form-control" type="number" name="id" placeholder="ID" value="{{ $id }}">
            </div>
            <div class="col-12 col-sm-4 mb-1">
                <input class="form-control" type="text" name="name" placeholder="URL Or Name" value="{{ $name }}">
            </div>
            <div class="col-12 col-sm-3 mb-1">
                <select class="form-control select2" name="tag">
                    <option value="0">Tag</option>
                    @foreach ($galleryTags as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $tag ? 'selected' : '' }}>{{ strtolower($item->news_type).'.'.strtolower($item->tag_type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-2 mb-1">
                <button type="submit" class="btn btn-success">Search</button>
            </div>
        </form>
    </div>
    <div class="col-12 col-sm-2 mb-2">
        <a href="{{ route('get_gallery_update_ad_route') }}" class="btn btn-primary float-right" role="button"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
    </div>
</div>

<div class="row py-2">
    @forelse ($galleryList as $item)
    <div class="col-12 col-sm-4 col-md-2 position-relative gallery-item mb-3">
        <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">
            <i class="fas fa-link"></i> {{ $item->id }}
        </a>
        <a href="{{ route('get_gallery_delete_ad_route', ['id' => $item->id]) }}" data-id="{{ $item->id }}"><i class="font-weight-bold fas fa-times"></i></a>
        <div class="div-img-center" data-url="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" style="background-image: url('{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}')"></div>
    </div>
    @empty
    <div class="col-12">
        <p class="alert alert-warning">No data</p>
    </div>
    @endforelse
    <div class="col-12 mb-3 text-center">
        {{ $galleryList->links() }}
    </div>
</div>
@endsection