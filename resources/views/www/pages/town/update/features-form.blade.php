<div id="feature-errors"></div>

<form action="{{ route('post_town_new_route') }}" method="POST" id="add-features-form" enctype="multipart/form-data">
    @csrf
    @unless ($category_item->id == 73)
    <div id="features" class="wrapper">
        <h3 class="px-3 px-lg-4 py-3"><i class="fas fa-list-ol mr-3"></i>特徴 <small><i>(Feature)</i></small></h3>
        <div class="p-3 p-lg-4">
            @if(isset($check_in))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">チェックイン時間（Check-in time）</label>
                <div class="col-12 col-lg-10">
                    <input class="form-control" name="check_in" value="{{ $check_in }}">
                </div>
            </div>
            @endif
            @if(isset($check_out))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">チェックアウト時間（Check out time）</label>
                <div class="col-12 col-lg-10">
                    <input class="form-control" name="check_out" value="{{ $check_out }}">
                </div>
            </div>
            @endif
            @if(isset($laundry))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">ランドリー（Laundry）</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_laundry">
                        <option value="-1" {{ !empty($laundry) && $laundry == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($laundry) || $laundry == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !empty($laundry) && $laundry != '0' && $laundry != '-1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <input type="text" class="form-control d-none" name="ip_laundry" placeholder="(Option) 有料/無料/..." value="{{ !empty($laundry) && $laundry != '0'  && $laundry != '-1'  && $laundry != '1' ? $laundry : '' }}">
                </div>
            </div>
            @endif
            @if(isset($breakfast))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">朝食 <br/> Breakfast</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_breakfast">
                        <option value="-1" {{ !empty($breakfast) && $breakfast == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($breakfast) || $breakfast == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !empty($breakfast) && $breakfast != '0' && $breakfast != '-1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <input type="text" class="form-control d-none" name="ip_breakfast" placeholder="(Option) Breakfast time" value="{{ !empty($breakfast) && $breakfast != '0' && $breakfast != '-1' && $breakfast != '1' ? $breakfast : '' }}">
                </div>
            </div>
            @endif
            @if(isset($shuttle))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">送迎<br/>（Pick-up）</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_shuttle">
                        <option value="-1" {{ $shuttle == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $shuttle == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $shuttle == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($air_condition))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">冷暖房 <br/> Air Conditioning</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_air_condition">
                        <option value="-1" {{ $air_condition == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $air_condition == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $air_condition == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($wifi))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">Wifi</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_wifi">
                        <option value="-1" {{ !empty($wifi) && $wifi == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($wifi) || $wifi == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !empty($wifi) && $wifi != '0' && $wifi != '-1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <input type="text" class="form-control d-none" name="ip_wifi" placeholder="(Option) Password" value="{{ !empty($wifi) && $wifi != '0' && $wifi != '-1' ? $wifi : '' }}">
                </div>
            </div>
            @endif
            @if(isset($parking))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">駐車場 <br/> Parking</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_parking">
                        <option value="-1" {{ !empty($parking) && $parking == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($parking) || $parking == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !empty($parking) && $parking != '0' && $parking != '-1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <input type="text" class="form-control d-none" name="ip_parking" placeholder="(Option) Guide" value="{{ !empty($parking) && $parking != '0' && $parking != '-1' && $parking != '1' ? $parking : '' }}">
                </div>
            </div>
            @endif
            @if(isset($kitchen))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">キッチン <br/> Kitchen</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_kitchen">
                        <option value="-1" {{ $kitchen == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $kitchen == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $kitchen == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($tv))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">テレビ <br/> TV</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_tv">
                        <option value="-1" {{ $tv == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $tv == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $tv == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($shower))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">シャワー <br/> Shower</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_shower">
                        <option value="-1" {{ $shower == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $shower == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $shower == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($bathtub))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">浴槽 <br/> Bathtub</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_bathtub">
                        <option value="-1" {{ $bathtub == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $bathtub == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $bathtub == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($luggage))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">荷物預かり <br/> Luggage Storage</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_luggage">
                        <option value="-1" {{ $luggage == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $luggage == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $luggage == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($private_room))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">個室 <br/> Private room</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_private_room">
                        <option value="-1" {{ !is_null($private_room) && $private_room[0] == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($private_room) || $private_room[0] == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !is_null($private_room) && $private_room[0] != '-1' && $private_room[0] != '0' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <select class="form-control d-none select2-no-search" name="sl_private_room_content[]" multiple>
                        @foreach ($private_room_list as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, $private_room) ? 'selected' : '' }}>{{ $item->value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            @if(isset($smoking))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">喫煙 <br/> Smoking</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_smoking">
                        <option value="-1" {{ !is_null($smoking) && $smoking == '-1' ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ is_null($smoking) || $smoking == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ !is_null($smoking) && $smoking != '0' && $smoking != '-1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-12 col-lg-7">
                    <input type="text" class="form-control d-none" name="ip_smoking" placeholder="(Option)" value="{{ !empty($smoking) && $smoking != '0' && $smoking != '-1' && $smoking != '1' ? $smoking : '' }}">
                </div>
            </div>
            @endif
            @if(isset($usage_scenes))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">利用シーン <br/> Usage Scenes</label>
                <div class="col-12 col-lg-10">
                    <select class="form-control select2-no-search" name="sl_usage_scenes[]" multiple>
                        @foreach ($usage_scene_list as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, $usage_scenes) ? 'selected' : '' }}>{{ $item->value }} {{ !empty($item->english_value) ? '('.$item->english_value.')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            @if(isset($service_tax))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">サービス税 <br/> Tax</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_service_tax">
                        @foreach ($service_tax_list as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $service_tax ? 'selected' : '' }}>{{ $item->value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            @if(isset($department))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">診療科 <br/> Department</label>
                <div class="col-12 col-lg-10">
                    <input type="text" class="form-control" name="department" name="{{ $department }}">
                </div>
            </div>
            @endif
            @if(isset($insurance))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right" style="font-size: 13px;">キャッシュレス対応</label>
                <div class="col-12 col-lg-3">
                    <select class="form-control" name="sl_insurance">
                        <option value="-1" {{ $insurance == -1 ? 'selected' : '' }}>未記入（Blank）</option>
                        <option value="0" {{ $insurance == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $insurance == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
            @endif
            @if(isset($language))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">対応言語 <br/> Available Language</label>
                <div class="col-12 col-lg-10 pt-2">
                    @foreach ($language_list as $item)
                    <div class="pretty p-icon p-round mb-2">
                        <input type="checkbox" name="language[]" value="{{ $item->id }}" {{ in_array($item->id, $language) ? 'checked' : '' }}>
                        <div class="state p-success">
                            <i class="icon mdi mdi-check"></i>
                        <label>{{ $item->value }} {{ !empty($item->english_value) ? '('.$item->english_value.')' : '' }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @if(isset($target_student))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">就学対象者<br/>Subject</label>
                <div class="col-12 col-lg-10">
                    <input type="text" class="form-control" name="target_student" value="{{ $target_student }}">
                </div>
            </div>
            @endif
            @if(isset($object))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">対象者<br/>Subjects</label>
                <div class="col-12 col-lg-10">`
                    <input type="text" class="form-control" name="object" value="{{ $object }}">
                </div>
            </div>
            @endif
            @if(isset($tuition_fee))
            <div class="row form-group">
                <label class="col-12 col-lg-2 d-inline-block col-form-label font-weight-bold text-lg-right">授業料<br>Fees</label>
                <div class="col-12 col-lg-10">
                    <input type="text" class="form-control" name="tuition_fee" value="{{ $tuition_fee }}">
                </div>
            </div>
            @endif
        </div>
    </div>
    @endunless
</form>
