@if(is_null($article->wifi) || $article->wifi == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">wifi</i>
            <span class="text d-flex align-items-center ml-2">Wifi</span>
        </div>
    </div>
@else
    @if($article->wifi != '-1')
        <div class="text-primary">
            <div class="d-flex">
                <i class="material-icons">wifi</i>
                <span class="text d-flex align-items-center ml-2">Wifi</span>
            </div>
            @if($article->wifi != '1')
                <div class="feature-detail">
                    <span class="text-dark d-flex align-items-center"> {!! $article->wifi !!}</span>
                </div>
            @endif
        </div>
    @endif
@endif

@if(is_null($article->parking) || $article->parking == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">local_parking</i>
            <span class="text d-flex align-items-center ml-2">駐車場</span>
        </div>
    </div>
@else
    @if($article->parking != '-1')
        <div class="text-primary">
            <div class="d-flex">
                <i class="material-icons">local_parking</i>
                <span class="text d-flex align-items-center ml-2">駐車場</span>
            </div>
            @if($article->parking != '1')
                <div class="feature-detail">
                    <span class="text-dark d-flex align-items-center"> {!! $article->parking !!}</span>
                </div>
            @endif
        </div>
    @endif
@endif

@if(is_null($article->smoking) || $article->smoking == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">smoke_free</i>
            <span class="text d-flex align-items-center ml-2">喫煙</span>
        </div>
    </div>
@else
    @if($article->smoking != '-1')
        <div class="text-primary">
            <div class="d-flex">
                <i class="material-icons">smoking_rooms</i>
                <span class="text d-flex align-items-center ml-2">喫煙</span>
            </div>
            @if($article->smoking != '1')
                <div class="feature-detail">
                    <span class="text-dark d-flex align-items-center"> {!! $article->smoking !!}</span>
                </div>
            @endif
        </div>
    @endif
@endif

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
<div class="{{ !is_null($result) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <i class="material-icons">local_florist</i>
        <span class="text d-flex align-items-center ml-2">利用シーン</span>
    </div>
@empty(!$result)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $result !!}</span>
    </div>
@endempty
</div>


@php
$service_tax = $service_tax_list->where('id', $article->service_tax)->first();
@endphp
<div class="{{ !is_null($service_tax) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <i class="material-icons">receipt</i>
        <span class="text d-flex align-items-center ml-2">サービス税</span>
    </div>
@empty(!$service_tax)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {{ $service_tax->value }}</span>
    </div>
@endempty
</div>


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
    <div class="{{ $result != '0' ? 'text-primary' : 'span-color' }}">
        <div class="d-flex">
            <i class="material-icons">meeting_room</i>
            <span class="text d-flex align-items-center ml-2">個室</span>
        </div>
    @empty(!$result)
        <div class="feature-detail">
            <span class="text-dark d-flex align-items-center"> {!! $result !!}</span>
        </div>
    @endempty
</div>
@endif
