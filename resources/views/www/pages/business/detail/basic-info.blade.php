@if($business_item->public_address)
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">住所</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->address }}
            @if (!empty($business_item->route_guide))
                <br/>
                <small>{{ $business_item->route_guide }}</small>
            @endif
        </div>
    </div>
@endif
@if(!is_null($business_item->founding_date))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">設立年月日</div>
        <div class="col-12 col-lg-9 dd">
            {{ date('Y-m-d', strtotime($business_item->founding_date)) }}
        </div>
    </div>
@endif
@if(!is_null($business_item->representator))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">代表者名</div>
        <div class="col-12 col-lg-9 dd">
            {!! $business_item->representator !!}
        </div>
    </div>
@endif
@if(!is_null($business_item->employee_number))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">従業員数</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->employee_number }}
        </div>
    </div>
@endif
@if(!is_null($business_item->outline))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">ミャンマーでの事業概要</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->outline }}
        </div>
    </div>
@endif
@if(!is_null($business_item->customer_object))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">顧客対象</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->customer_object }}
        </div>
    </div>
@endif
@if(!is_null($business_item->partner))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">主な取引先業種</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->partner}}
        </div>
    </div>
@endif
@if(!is_null($business_item->capital))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">資本金</div>
        <div class="col-12 col-lg-9 dd">
            {{ $business_item->capital }}
        </div>
    </div>
@endif
@if($business_item->public_phone)
    <span id="company-phone" class="scroll-spy"></span>
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">電話番号</div>
        <div class="col-12 col-lg-9 dd">
            <a href="tel:{{ $business_item->phone }}">{{ $business_item->phone }}</a>
        </div>
    </div>
@endif
@if(!is_null($business_item->repre_phone))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">代表者電話番号</div>
        <div class="col-12 col-lg-9 dd">
            <a href="tel:{{ $business_item->repre_phone}}">{{ $business_item->repre_phone }}</a>
        </div>
    </div>
@endif
@if(!is_null($business_item->website))
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">詳細リンク</div>
        <div class="col-12 col-lg-9 dd">
            <a href="{{ $business_item->website }}">{{ $business_item->website }}</a>
        </div>
    </div>
@endif
@if($business_item->public_email)
    <div class="info-item">
        <div class="col-12 col-lg-3 dt">メール</div>
        <div class="col-12 col-lg-9 dd">
            <a href="mailto:{{ $business_item->email }}">{{ $business_item->email }}</a>
        </div>
    </div>
@endif