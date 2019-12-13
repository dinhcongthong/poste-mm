@extends('admin.layouts.master')

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 py-2">            
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
            <div class="col-12 col-sm-8">
                <form action="{{ $id == 0 ? route('post_golf_shop_add_ad_route') : route('post_golf_shop_edit_ad_route', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $id }}" name="id">
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Name</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{ $name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Slug</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="slug" value="{{ $slug }}" placeholder="Option">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Keywords</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="keywords" value="{{ $keywords }}" required placeholder="Keyword1,Keyword2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Description</label>
                        <div class="col-12 col-sm-10">
                            <textarea class="form-control" rows="5" id="description" name="description" required>{{ $description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">City</label>
                        <div class="col-12 col-sm-5">
                            <select class="form-control select2" name="city_id" required>
                                <option value="">Please choose city</option>
                                @foreach($cityList as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $cityId ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-12 col-sm-1 col-form-label text-right">District</label>
                        <div class="col-12 col-sm-4">
                            <select class="form-control select2" name="district_id">
                                <option value="">Please choose district</option>
                                @foreach($districtList as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $districtId ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Address</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="address" value="{{ $address }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Phone</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="phone" value="{{ $phone }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Work Time</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="work_time" value="{{ $workTime }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Website</label>
                        <div class="col-12 col-sm-10">
                            <input type="url" class="form-control" name="website" value="{{ $website }}" placeholder="Option">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Image</label>
                        <div class="col-12 col-sm-10">
                            <div class="row">
                                <div class="col-12 col-sm-9 col-md-6">
                                    <input class="form-control" name="thumb_url" value="{{ $thumbURL }}" readonly>
                                </div>
                                <div class="col-12 col-sm-3 col-md-2 d-flex align-items-center">
                                    <input type="file" name="image" data-max-size="4">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-10 offset-2 font-italic">
                            <b>File size: </b> jpeg, png, jpg<br/>
                            <b>Max file size: </b> 2MB <br/>
                            <b>Dimension ratio: </b> 4:3 <br/>
                            <b>Min width: </b>200px
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Map</label>
                        <div class="col-12 col-sm-10">
                            <input type="text" class="form-control" name="map" value="{{ $map }}" placeholder="Option">
                            <i>Please get <b>PlaceId</b> from <a href="https://developers.google.com/maps/documentation/javascript/examples/places-placeid-finder" target="_blank">Google PlaceID Finder</a> or get <b>longtitude, latitude</b> from <a href="https://www.google.com/maps" target="_blank">Google Map</a></i>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-right">Status</label>
                        <div class="col-12 col-sm-10">
                            <select class="form-control select2-no-search" name="status">
                                <option value="1">Published</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-10 offset-sm-2">
                            <a href="{{ route('get_golf_index_ad_route') }}" role="button" class="btn btn-outline-primary mx-1">Cancel</a>
                            <button type="submit" class="btn btn-primary mx-1">Publish</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 col-sm-4">
                <div class="card">
                    <div class="card-header">
                        Images
                    </div>
                    <div class="card-body">
                        <div class="alert alert-secondary">
                            <ul class="m-0 pl-3">
                                <li><b>Max image size:</b> 2MB</li>
                                <li><b>Image Dimension:</b> 4x3</li>
                                <li><b>Image type:</b> jpeg, jpg, png</li>
                                <li><b>Min width:</b> 400px</li>
                            </ul>
                        </div>
                        <div class="row" id="preview-images">
                            <div class="col-12" id="pre-img">
                                @foreach ($golfImages as $item)
                                <div class="col-12 mb-3" id="pre-img-{{ $item->id }}">
                                    <div class="w-100">
                                        <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                                    </div>
                                    <a class="btn-delete-golf-img float-right" href="#" data-id="{{ $item->id }}">Delete</a>
                                    <div class="clearfix"></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="file" name="upload_file" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).on('ready', function() {
        $(window).on('beforeunload', function() {
            if(iWantTo) {
                return 'you are an idito';
            }
        });
    });
</script>
@endsection