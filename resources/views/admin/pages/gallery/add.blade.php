@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 border border-secondary rounded py-2">
        
        @if(Session::has('result') && !session('result'))
        <p class="alert alert-danger">{{ session('error') }}</p>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 w-100">
                @foreach ($errors->all() as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('post_gallery_update_ad_route') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="form-group col-12 col-sm-6">
                    <label for="name">Tag</label>
                    <select class="form-control select2" name="tag" required>
                        <option value="">Please choose tag</option>
                        @foreach ($galleryTags as $item)
                        <option value="{{ $item->id }}">{{ $item->news_type.'.'.$item->tag_type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-sm-6">
                    <label for="name">Dimension</label>
                    <select class="form-control select2" name="dimension">
                        <option value="">Original Size</option>
                        @foreach ($dimensionList as $key => $item)
                        <option value="{{ $key }}">{{ $key.' ('.$item[0].'x'.$item[1].')' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-12 px-0 mb-1">
					<i>
						You can choose one or many photos<br/>
						Supported extensions: jpg, jpeg, gif, png, bmp, svg<br/>
						Size limit: 2MB
					</i>
				</div>
                <input type="file" name="fileImages[]" multiple />
            </div>
            
            <div class="form-group text-center">
                <a class="btn btn-outline-primary mx-2" href="{{ route('get_gallery_index_ad_route') }}">Back</a>
                <button class="btn btn-primary mx-2" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection