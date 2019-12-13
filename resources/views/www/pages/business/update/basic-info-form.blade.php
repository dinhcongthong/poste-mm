<div id="company-header" class="company-internet g-col-12 rounded rounded-bottom-0 p-3 p-lg-4 d-flex flex-wrap align-items-center">
    <div class="col p-0 text-light text-center">
        <h2 class="fw-bold m-0">{{ $pageTitle }}</h2>
    </div>
</div>
<div id="business-sidebar" class="g-col-lg-4 g-col-12 px-2 pl-lg-4">
    <div class="sticky-top sticky-top-except-nav" id="sticky">
        <div class="form-group">
            <label class="label-control">カテゴリーを選択する</label>
            <select class="form-control select2" name="category_ids[]" multiple="multiple" required>
                @foreach ($businessCategoryList as $item)
                    <optgroup label="{{ $item->name }}">
                        @foreach ($item->getChildrenCategory as $sub)
                            <option value="{{ $sub->id }}" {{ in_array($sub->id, $category_ids) ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="label-control">サムネイル画像</label>
            <br/>
            <img class="img-fluid" name="avatar_preview" src="{{ $thumb_url }}">
            <br/>
            <input type="url" name="avatar_url" readonly class="form-control" value="{{ $thumb_url }}">
            <br/>
            <input type="file" name="avatar">
        </div>
    </div>
</div>
<div id="company-info" class="g-col-12 g-col-lg-8 px-3 pl-lg-4">
    @if($errors->any())
        <div class="alert alert-danger mb-1">
            <ul class="mb-0 w-100">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="company-intro mb-3 mb-lg-4">
        <div class="divider"></div>
    </div>
    <div class="mb-3 mb-lg-4">
        <span id="company-general" class="scroll-spy"></span>
        <div class="row d-none" id="name_errors"></div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt mb-2 mb-lg-0">社名</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="name" value="{{ $name }}" required>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt mb-2 mb-lg-0">会社概要</div>
            <div class="col-12 col-lg-9 dd">
                <textarea class="form-control" rows="3" name="description" required>{{ $description }}</textarea>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">メール</div>
            <div class="col-12 col-lg-9 dd">
                <input type="email" class="form-control" name="email" value="{{ $email }}">
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">電話番号</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="phone" value="{{ $phone }}">
            </div>
        </div>
        <div class="company-intro mb-3 mb-lg-4">
            <div class="divider"></div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt mb-2 mb-lg-0">設立年月日</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="founding_date" value="{{ $founding_date }}">
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt mb-2 mb-lg-0">代表者名</div>
            <div class="col-12 col-lg-9 dd">
                <textarea class="form-control" rows="3" name="representator">{{ $representator }}</textarea>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">従業員数</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="employee_number" value="{{ $employee_number }}">
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">ミャンマーでの事業概要</div>
            <div class="col-12 col-lg-9 dd">
                <textarea class="form-control" rows="3" name="outline">{{ $outline }}</textarea>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">顧客対象</div>
            <div class="col-12 col-lg-9 dd">
                <textarea class="form-control" rows="3" name="customer_object">{{ $customer_object }}</textarea>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">主な取引先業種</div>
            <div class="col-12 col-lg-9 dd">
                <textarea class="form-control" rows="3" name="partner">{{ $partner }}</textarea>
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">資本金</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="capital" value="{{ $capital }}">
            </div>
        </div>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">代表者電話番号</div>
            <div class="col-12 col-lg-9 dd">
                <input type="text" class="form-control" name="repre_phone" value="{{ $repre_phone }}">
            </div>
        </div>
        <span id="company-map" class="scroll-spy"></span>
        <div class="info-item">
            <div class="col-12 col-lg-3 dt">詳細リンク</div>
            <div class="col-12 col-lg-9 dd">
                <input type="url" class="form-control" name="website" value="{{ $website }}">
            </div>
        </div>
    </div>
</div>
