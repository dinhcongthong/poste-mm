@extends('www.pages.personal-trading.master')

@section('personal-content')    
<h3 class="title">個人売買投稿画面</h3>

<div class="form">
    <form action="{{ $id != 0 ? route('post_personal_trading_edit_route', $articleSlug) : route('post_personal_trading_add_route') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $id }}" name="id">
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
        <div class="form-group row">
            <div class="col-12 col-sm-10 offset-sm-2" id="option-realestate" style="padding-top: calc(.375rem + 1px);">
                @foreach ($personalTypeList as $item)     
                <div class="pretty p-icon p-round mb-2">
                    <input type="radio" name="type_id" value="{{ $item->id }}" {{ $typeId == $item->id ? 'checked' : '' }} required />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>{{ $item->value }}</label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">商品ジャンル別</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="category_id" required>
                    <option value="">売り買い別表示...</option>
                    @foreach ($productCategoryList as $item)
                    <option value="{{ $item->id }}" {{ $categoryId == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row {{ $typeId != 21 ? 'd-none' : '' }}" id="personal-image-div">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">写真</label>
            <div class="col-12 col-sm-10 pl-sm-0">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-2 mb-sm-0 d-flex flex-wrap align-items-end justify-content-center">
                        <input type="hidden" name="pre_image1" value="{{ $firstImage }}">
                        <input id="input-image1" type="file" name="image1">
                    </div>
                    <div class="col-12 col-sm-6 d-flex flex-wrap align-items-end justify-content-center">
                        <input type="hidden" name="pre_image2" value="{{ $secondImage }}">
                        <input id="input-image2" type="file" name="image2">
                    </div>
                    <div class="col-12 mt-2">
                        <b>ファイルの種類：</b> jpg, jpeg, gif, png<br/>
                        <b>写真容量：</b> 2MB以下 
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">商品名</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">希望価格</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" name="price" value="{{ $price }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">場所</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" name="address" value="{{ $address }}" required>
            </div>
        </div>
        <div class="form-group row {{ $typeId != 21 ? 'd-none' : '' }}" id="personal-delivery-select">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">商品受け渡し方法</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="delivery_id">
                    <option value="0">商品受け渡し方法...</option>
                    @foreach ($deliveryList as $item)
                    <option value="{{ $item->id }}" {{ $deliveryId == $item->id ? 'selected' : '' }}>{{ $item->value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">備考</label>
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