{{-- Wifi --}}
@if(is_null($article->wifi) || $article->wifi == '0')
    <button type="button" class="swiper-slide btn btn-light disable" data-toggle="tooltip" data-placement="bottom" data-html="true">
        <i class="material-icons">wifi</i>
        <span class="text">Wifi</span>
    </button>
@else
    @if($article->wifi != '-1')
        <button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true"  title="{{ $article->wifi != '1' ? 'Password: '.$article->wifi : '' }}">
            <i class="material-icons">wifi</i>
            <span class="text">Wifi</span>
        </button>
    @endif
@endif
{{-- End Wifi --}}

{{-- Parking --}}
@if(is_null($article->parking) || $article->parking == '0')
    <button type="button" class="swiper-slide btn btn-light disable" data-toggle="tooltip" data-placement="bottom" data-html="true">
        <i class="material-icons">local_parking</i>
        <span class="text">駐車場</span>
    </button>
@else
    @if($article->parking != '-1')
        <button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $article->parking != '1' ? $article->parking : '' }}">
            <i class="material-icons">local_parking</i>
            <span class="text">駐車場</span>
        </button>
    @endif
@endif
{{-- End Parking --}}

{{-- Private Room --}}
@php
if(is_null($article->private_room) || $article->private_room == '0') {
    $result = '0';
} else {
    if($article->private_room == '-1') {
        $result = '-1';
    } elseif($article->private_room != '1') {
        $privates = explode(',', $article->private_room);
        $result = '';
        foreach ($private_room_list as $room) {
            if(in_array($room->id, $privates)) {
                if(empty($result)) {
                    $result = "<ul class='p-3 m-0 text-left'>";
                    $result .= "<li>$room->value</li>";
                } else {
                    $result .= "<li>$room->value</li>";
                }
            }
        }
        if(!empty($result)) {
            $result .= "</ul>";
        }
    } else {
        $result = '';
    }
}
@endphp
@if($result != -1)
    <button type="button" class="swiper-slide btn btn-light {{ $result != '0' ? '' : 'disable' }}" data-toggle="tooltip" data-placement="bottom" data-html="true" {!! $result != '0' ? 'title="'.$result.'"' : '' !!}>
        <i class="material-icons">meeting_room</i>
        <span class="text">個室</span>
    </button>
@endif
{{-- End Private Room --}}

{{-- Usage Scences --}}
@php
if(is_null($article->usage_scenes)) {
    $result = null;
} else {
    if($article->usage_scenes != '0') {
        $usage_scenes = explode(',', $article->usage_scenes);
        $result = '';
        foreach ($usage_scenes_list as $item) {
            if(in_array($item->id, $usage_scenes)) {
                if(empty($result)) {
                    $result = "<ul class='p-3 m-0 text-left'>";
                    $result .= "<li>$item->value</li>";
                } else {
                    $result .= "<li>$item->value</li>";
                }
            }
        }

        if(!empty($result)) {
            $result .= "</ul>";
        }
    } else {
        $resutl = '';
    }
}
@endphp
<button type="button" class="swiper-slide {{ is_null($result) ? 'disable' : '' }} btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! !is_null($result) ? $result : '' !!}">
    <i class="material-icons">local_florist</i>
    <span class="text">利用シーン</span>
</button>
{{-- End Usage Scences --}}

{{-- SErvice Tax --}}
@php
$service_tax = $service_tax_list->where('id', $article->service_tax)->first();
@endphp
<button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $service_tax->value }}">
    <i class="material-icons">receipt</i>
    <span class="text">サービス税</span>
</button>
{{-- End SErvice Tax --}}


{{-- Smoking --}}
@if(is_null($article->smoking) || $article->smoking == '0')
    <button type="button"class="swiper-slide btn btn-light disable" data-toggle="tooltip" data-placement="bottom" data-html="true">
        <i class="material-icons">smoke_free</i>
        <span class="text">喫煙</span>
    </button>
@else
    @if($article->smoking != '-1')
        <button type="button"class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $article->smoking != '1' ? $article->smoking : '' }}">
            <i class="material-icons">smoking_rooms</i>
            <span class="text">喫煙</span>
        </button>
    @endif
@endif
{{-- End Smoking --}}
