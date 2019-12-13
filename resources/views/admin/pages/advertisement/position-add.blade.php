@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id != 0 ? route('post_ads_position_edit_ad_route', ['id' => $id]) : route('post_ads_position_add_ad_route') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}" />
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ $slug }}">
            </div>
            <div class="form-group">
                <label>How to show</label>
                <select class="form-control select2-no-search" name="how_to_show" required>
                   @foreach($howToShowList as $key => $item)
                   <option value="{{ $key }}" {{ $howToShowId == $key ? 'selected' : '' }}>{{ $item }}</option>
                   @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{!! $description !!}</textarea>
            </div>
            <div class="form-group">
                <label>Version Show</label>
                <select class="form-control select2-no-search" name="version_show" required>
                    @foreach ($versionShowList as $key => $item)
                          <option value="{{ $key }}" {{ $key == $versionShowId ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-center">
                <a class="mx-1 btn btn-outline-primary" href="{{ route('get_ads_position_ad_route') }}">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>    
@endsection