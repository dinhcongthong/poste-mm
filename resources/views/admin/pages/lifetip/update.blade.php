@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-12 col-sm-12 py-2">
        <form action="#" method="POST" enctype="multipart/form-data">
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
            <input type="hidden" value="{{ $id }}" name="id">
            <input type="hidden" value="0" name="customer_id">
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Name</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="name" value="{{ $name }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Slug</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="slug" placeholder="Option" value="{{ $slug }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Keywords</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input type="text" class="form-control" name="keywords" placeholder="Ex: keyword1,keywords2" value="{{ $keywords }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Category</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <select class="form-control select2" name="category_ids[]" multiple>
                        @foreach ($categoryList as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, $categoryIds) ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">City</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <select class="form-control select2" name="city_id">
                        @foreach ($cityList as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $cityId ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
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
                            <input type="file" name="image" data-max-size="2">
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
                <label class="col-12 col-sm-2 col-form-label text-right">Description</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <textarea  required name="description" id="description" rows="5" class="form-control">{{ $description }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Content</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" href="#page1" data-toggle="tab">Page 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#page2" data-toggle="tab">Page 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#page3" data-toggle="tab">Page 3</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane container active" id="page1">
                            <div class="row py-3">
                                <div class="col-12 px-0 mb-3">
                                    <input class="form-control" name="title_content[]" value="{{ $titles[0] }}" placeholder="Page 1 Title">
                                </div>
                                <div class="col-12 px-0">
                                    <textarea class="form-control" id="content-1" name="content[]">{{ $contents[0] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="page2">
                            <div class="row py-3">
                                <div class="col-12 px-0 mb-3">
                                    <input class="form-control" name="title_content[]" value="{{ $titles[1] }}" placeholder="Page 2 Title">
                                </div>
                                <div class="col-12 px-0">
                                    <textarea class="form-control" id="content-2" name="content[]">{{ $contents[1] }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="page3">
                            <div class="row py-3">
                                <div class="col-12 px-0 mb-3">
                                    <input class="form-control" name="title_content[]" value="{{ $titles[2] }}" placeholder="Page 3 Title">
                                </div>
                                <div class="col-12 px-0">
                                    <textarea class="form-control" id="content-3" name="content[]">{{ $contents[2] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Author</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <textarea class="form-control" id="author" rows="5" name="author">{{ $author }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Published Date</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input class="form-control" id="publish-date" name="published_at" value="{{ $publishedDate }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Related Articles</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <input class="form-control" name="related_ids" value="{{ $relatedIds }}" placeholder="Ex: 123, 328,...">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-12 col-sm-2 col-form-label text-right">Status</label>
                <div class="col-12 col-sm-10 col-md-7">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <select class="form-control select2-no-search" name="status">
                                <option value="1" {{ $status ? 'selected' : '' }}>Publishing</option>
                                <option value="0" {{ !$status ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group offset-sm-2 col-12 col-sm-10 col-md-7 text-center">
                <a href="{{ route('get_lifetip_index_ad_route') }}" class="btn btn-outline-primary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection