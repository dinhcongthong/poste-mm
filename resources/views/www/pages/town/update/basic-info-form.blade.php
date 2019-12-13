<form action="{{ route('post_town_new_route') }}" class="w-100" method="POST" id="add-step2-form" enctype="multipart/form-data">
    @csrf

    {{-- Avatar  --}}
    <div class="row no-gutters">
        <div class="col-12 col-lg-3 p-0 text-center">
            <input type="hidden" name="avatar_url" value="{{ $avatar }}">
            <div class="kv-avatar w-100">
                <div class="file-loading w-100 text-center">
                    <input id="avatar-2" name="avatar" type="file">
                </div>
                <p class="text-center">
                    <b>Image type:</b> jpg, jpeg, png<br/>
                    <b>Image max size:</b> <span class="text-danger">2MB</span> <br/>
                    <b>Image Min width:</b> 200px
                </p>
            </div>
        </div>
        {{-- End Avatar  --}}

        {{-- Basic Info --}}
        <div class="col-12 col-lg-9 p-3">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">店名 <br/> Store Name</label>
                        <div class="col-12 col-lg-10">
                            <input type="text" class="form-control" name="name" value="{{ $name }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">住所</label>
                <div class="col-12 col-lg-10">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                            <select class="form-control" name="city_id" required>
                                <option value="">都市名を選択してください / Please choose City</option>
                                @foreach ($city_list as $item)
                                    <option value="{{ $item->id }}" {{ $city_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <input class="form-control" type="text" name="address" value="{{ $address }}" placeholder="Address" required>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($route_guide))
                <div class="row form-group">
                    <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">経路案内 <br/> Route guide</label>
                    <div class="col-12 col-lg-10">
                        <input type="text" class="form-control" name="route_guide" value="{{ $route_guide }}">
                    </div>
                </div>
            @endif

            {{-- @if(isset($regular_close))
                <div class="row form-group">
                    <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">定休日 <br/> Regular Closing Day</label>
                    <div class="col-12 col-lg-10">
                        <input type="text" class="form-control" name="regular_close" value="{{ $regular_close }}">
                    </div>
                </div>
            @endif --}}
            @if(isset($phone))
                <div class="row form-group">
                    <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">電話 <br/> Phone Number</label>
                    <div class="col-12 col-lg-10">
                        <input type="text" class="form-control" name="phone" value="{{ $phone }}" placeholder="0123456789,0123456789">
                    </div>
                </div>
            @endif
            @if(isset($email))
                <div class="row form-group">
                    <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">Email</label>
                    <div class="col-12 col-lg-10">
                        <input type="email" class="form-control" name="email" value="{{ $email }}">
                    </div>
                </div>
            @endif

            <div class="row form-group">
                <label for="" class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">Tags</label>
                <div class="col-12 col-lg-10">
                    <select class="form-control" multiple name="tags[]" id="town-tags-select">
                        @foreach ($tag_list as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, $article_tags) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if(isset($website) || isset($facebook))
                <div class="row form-group">
                    @if(isset($website))
                        <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">Website</label>
                        <div class="col-12 col-lg-4">
                            <input type="url" class="form-control" name="website" value="{{ $website }}">
                        </div>
                    @endif
                    @if(isset($facebook))
                        <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">Facebook</label>
                        <div class="col-12 col-lg-4">
                            <input type="url" class="form-control" name="facebook" value="{{ $facebook }}">
                        </div>
                    @endif
                </div>
            @endif
            @if(isset($budget) || isset($currency))
                <div class="row form-group">
                    @if(isset($budget))
                        <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">予算 <br/> Budget</label>
                        <div class="col-12 col-lg-4">
                            <input type="text" class="form-control" name="budget" value="{{ $budget }}">
                        </div>
                    @endif
                    @if(isset($currency))
                        <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">支払い通貨 <br/> Currency</label>
                        <div class="col-12 col-lg-4 d-flex currency align-items-center" style="padding-top: calc(.375rem + 1px);">
                            @foreach ($currency_list as $item)
                                <div class="pretty p-icon p-round mb-2">
                                    <input type="checkbox" name="currency[]" value="{{ $item->id }}" {{ in_array($item->id, $currency) ? 'checked' : '' }}>
                                    <div class="state p-success">
                                        <i class="icon mdi mdi-check"></i>
                                        <label>{{ $item->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
            @if(isset($credit))
                <div class="row form-group">
                    <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right" style="font-size: 13px;">クレジットカード <br/> Credit card</label>
                    <div class="col-12 col-lg-10 d-flex flex-wrap flex-md-no-wrap align-items-center" id="credit">
                        @foreach ($credit_list as $item)
                            <div class="pretty p-icon p-round mb-2">
                                <input type="checkbox" name="credit[]" value="{{ $item->id }}" {{ in_array($item->id, $credit) ? 'checked' : '' }}>
                                <div class="state p-primary">
                                    <i class="icon mdi mdi-check"></i>
                                    <label>
                                        @switch($item->id)
                                            @case(29)
                                            <i class="fab fa-cc-mastercard fa-2x" title="{{ $item->value }}"></i>
                                            @break
                                            @case(30)
                                            <i class="fab fa-cc-jcb fa-2x" title="{{ $item->value }}"></i>
                                            @break
                                            @case(57)
                                            <img src="{{ asset('images/poste/mpu.svg') }}" style="width: 2.28rem; margin-left: 1rem;" alt="{{ $item->value}}" title="{{ $item->value }}">
                                            @break
                                            @case(58)
                                            <img src="{{ asset('images/poste/unionpay.svg') }}" style="width: 2.28rem; margin-left: 1rem;" alt="{{ $item->value}}" title="{{ $item->value }}">
                                            @break
                                            @default
                                            <i class="fab fa-cc-visa fa-2x" title="{{ $item->value }}"></i>
                                        @endswitch
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        {{-- End Basic Info --}}
    </div>
</form>
