@extends('admin.layouts.master')

@section('content')
<div class="row">
    
    <div class="col-12 col-sm-12 py-2">
        <form action="{{ $id != 0 ? route('post_movie_edit_ad_route', ['id' => $id]) : route('post_movie_add_ad_route') }}" method="POST" enctype="multipart/form-data">
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
            
            <div class="row">
                <div class="col-12 col-sm">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Genres</label>
                        <input type="text" class="form-control" name="genres" value="{{ $genres }}" placeholder="Option">
                    </div>
                    <div class="form-group">
                        <label>Actors</label>
                        <input type="text" class="form-control" name="actors" value="{{ $actors }}" placeholder="Option">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="thumb_url" value="{{ $thumbURL }}" readonly>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="file" name="thumbnail" data-max-size="4">
                            </div>
                            <div class="col-12 font-italic">
                                <b>Image type: </b> jpeg, jpg, png <br/>
                                <b>Image Size: </b> 2MB <br/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Trailer Youtube URL</label>
                        <input type="text" class="form-control mb-1" name="trailer" value="{{ $trailer }}" placeholder="Option">
                        <img class="img-responsive" src="{{ asset('images/poste/movie_trailer_id.png') }}">
                        <p>Please get value of <span class="font-weight-bold">v=</span> in <span class="font-weight-bold">Youtube URL</span></p>
                    </div>
                </div>
                <div class="col-12 col-sm">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" id="description" required>{{ $description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Release Date</label>
                        <input type="text" class="form-control" id="published-date" name="published_date" value="{{ $publishedDate }}" required>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a class="mx-2 btn btn-outline-primary" href="{{ route('get_movie_index_ad_route') }}">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>    
@endsection