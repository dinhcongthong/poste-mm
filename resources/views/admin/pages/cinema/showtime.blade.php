@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 py-2">
        <form action="{{ route('post_showtime_update_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Movie</label>
                        <select class="select2 form-control" name="movie_id" required>
                            <option value="">Please choose movie</option>
                            @foreach ($movieList as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach                            
                        </select>
                    </div>
                </div>
                <div class="col">
                    <label>City</label>
                    <select class="select2 form-control" name="city_id" required>
                        <option value=""> Please choose City</option>
                        @foreach ($cityList as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row py-2">
                <div class="col">
                    <button class="btn btn-success" type="button" id="btn-add-showtime">Add more showtime</button>
                </div>
                <div class="col text-right">
                    <a href="{{ route('get_movie_index_ad_route') }}" class="btn btn-outline-primary mx-3">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <div class="row py-2" id="showtime-list">
                
            </div>
        </form>
    </div>
</div>
@endsection