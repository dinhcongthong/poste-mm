@extends('www.pages.bullboard.master')

@section('bullboard-content')
<h3 class="title">情報掲示板投稿画面 </h3>

<div class="form">
    <form action="{{ $id != 0 ? route('post_bullboard_edit_route', $articleSlug) : route('post_bullboard_add_route') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if($errors->any())
        <div class="form-group">
            <div class="alert alert-danger">
                <ul class="mb-0 w-100">
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <input type="hidden" value="{{ $id }}" name="id">
        
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">情報別</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="category_id" required>
                    <option value="">情報別...</option>\
                    @foreach ($bullboardCategoryList as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $categoryId ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">タイトル</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">場所</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="address" value="{{ $address }}" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">写真</label>
            <div class="col-12 col-sm-10 pl-sm-0">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-2 mb-sm-0 d-flex flex-wrap align-items-end justify-content-center">
                        <input type="hidden" name="pre_image1" value="{{ $firstImage }}">
                        <input id="input-image1" type="file" name="image1" value="{{ $firstImage }}">
                    </div>
                    <div class="col-12 col-sm-6 d-flex flex-wrap align-items-end justify-content-center">
                        <input type="hidden" name="pre_image2" value="{{ $secondImage }}">
                        <input id="input-image2" type="file" name="image2" value="{{ $secondImage }}">
                    </div>
                    <div class="col-12 mt-2">
                        <b>ファイルの種類：</b> jpg, jpeg, gif, png<br/>
                        <b>写真容量：</b> 2MB以下 
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">日程</label>
            <div class="col-12 col-sm-10">
                <div class="input-group">
                    <input type="text" aria-label="Start date" class="form-control" placeholder="Start Date (YYYY-mm-dd)" name="start_date" value="{{ $startDate }}">
                    <div class="input-group-prepend">
                        <span class="input-group-text">to</span>
                    </div>
                    <input type="text" aria-label="End Date" class="form-control" placeholder="End Date (YYYY-mm-dd)" name="end_date" value="{{ $endDate }}">
                </div>
            </div>
        </div> --}}
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">掲載内容</label>
            <div class="col-12 col-sm-10">
                <textarea class="form-control" id="textarea-content" name="content">{{ $content }}</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-12 col-sm-10 offset-sm-2">
                <div class="seperate my-1"></div>
                <h3 class="font-weight-bold sub-title-form">連絡先情報</h3>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">メールアドレス</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="email" type="email" value="{{ $email }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">電話番号/その他</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="phone" type="tel" value="{{ $phone }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">電話番号掲載</label>
            <div class="col-12 col-sm-10 d-flex flex-wrap flex-items-center">
                <div class="pretty pretty p-default p-round p-thick mt-1 p-smooth">
                    <input type="checkbox" name="show_phone_num" value="1" {{ $showPhone ? 'checked' : '' }} />
                    <div class="state p-primary-o">
                        <label>掲載する</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-12 col-sm-10 offset-sm-2">
                <div class="bg-accept p-4">
                    <p class="m-0">ご利用にあたっての <a href="{{ route('get_term_of_use_route')}}" target="_blank">お約束事</a></p>
                    <div class="pretty pretty p-default p-round p-thick p-smooth mt-2">
                        <input type="checkbox" name="accept" value="1" required />
                        <div class="state p-primary-o">
                            <label>お約束事に同意する</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">サイトに公開する</button>
        </div>
    </form>
</div>
@endsection