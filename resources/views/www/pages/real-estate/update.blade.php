@extends('www.pages.real-estate.master')

@section('real-content')
<h3 class="title">不動産情報投稿画面</h3>

<div class="form">
    <form action="{{ empty($articleSlug) ? route('post_real_estate_add_route') : route('post_real_estate_edit_route', $articleSlug) }}" method="POST" enctype="multipart/form-data">
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
        
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">目的別</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="type_id" required>
                    <option value="">どれか1つを選択してください...</option>
                    @foreach ($realestate_type_list as $item)
                    <option value="{{ $item->id }}" {{ $typeId == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">不動産の名前</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
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
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">不動産形態</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="category_id" required>
                    <option value="">不動産形態...</option>
                    @foreach ($realestate_category_list as $item)
                    <option value="{{ $item->id }}" {{ $categoryId == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">不動産形態</label>
            <div class="col-12 col-sm-10">
                <div class="row">
                    <div class="col-12 col-sm-6 d-flex flex-wrap align-items-end justify-content-center">
                        <select class="form-control" name="city_id" required>
                            <option value="">場所...</option>
                            @foreach ($city_list as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $cityId ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 d-flex flex-wrap align-items-end justify-content-center">
                        <select class="form-control" name="district_id">
                            <option value="0">立地...</option>
                            @foreach ($district_list as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $districtId ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">賃料</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="price_id" required>
                    <option value="">賃料...</option>
                    @foreach ($realestate_price_list as $item)
                    <option value="{{ $item->id }}" {{ $priceId == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">間取りから探す</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="bedroom_id" required>
                    <option value="">間取りから探す...</option>
                    @foreach ($realestate_bedroom_list as $item)
                    <option value="{{ $item->id }}" {{ $bedroomId == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach                    
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">オプション</label>
            <div class="col-12 col-sm-10 d-flex flex-wrap" id="option-realestate" style="padding-top: calc(.375rem + 1px);">
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="full_furniture" value="1" {{ $full_furniture ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>家具付き</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="internet" value="1" {{ $internet ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>インターネット</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="bathtub" value="1" {{ $bathtub ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>バスタブ</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="gym" value="1" {{ $gym ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>スポーツジム</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="electronic" value="1" {{ $electronic ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>家電付き</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="television" value="1" {{ $television ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>テレビ</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="kitchen" value="1" {{ $kitchen ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>キッチン</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="garage" value="1" {{ $garage ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>駐車場</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="security" value="1" {{ $security ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>24時間警備</label>
                    </div>
                </div>
                <div class="pretty p-icon p-curve col-6 col-md-4 col-lg-3 m-0 mb-2">
                    <input type="checkbox" name="pool" value="1" {{ $pool ? 'checked' : '' }} />
                    <div class="state p-success">
                        <i class="icon mdi mdi-check"></i>
                        <label>プール</label>
                    </div>
                </div>
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
                <input class="form-control" name="phone" type="tel" {{ $phone }}>
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