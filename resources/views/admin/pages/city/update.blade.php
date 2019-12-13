@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        <form action="{{ $id != 0 ? route('post_city_edit_ad_route', ['id' => $id]) : route('post_city_add_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="id" value="{{ $id }}">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ $name }}" required>
            </div> 
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ $slug }}">
            </div> 
            <div class="form-group text-center">
                <a class="btn btn-outline-primary mx-1" href="{{ route('get_city_index_ad_route') }}">Back</a>
                <button type="submit" class="btn btn-primary mx-1">Submit</button>
            </div>
        </form>
    </div>
</div>   
@endsection