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

{{-- SErvice Tax --}}
@php
$service_tax = $service_tax_list->where('id', $article->service_tax)->first();
@endphp
<button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $service_tax->value }}">
    <i class="material-icons">receipt</i>
    <span class="text">サービス税</span>
</button>
{{-- End SErvice Tax --}}

{{-- Department --}}
<button type="button" class="swiper-slide btn btn-light {{ !empty($article->department) ? '' : 'disable' }}" data-toggle="tooltip" data-placement="bottom" data-html="true"  title="{{ !empty($article->department) ? $article->department : '' }}">
    <span class="icon">診療科</span>
</button>
{{-- End Department --}}

{{-- Insurance --}}
@if($article->insurance != -1)
    <button type="button" class="swiper-slide btn btn-light {{ $article->insurance ? 'disable' : '' }}">
        <span class="icon">キャッシュレス対応</span>
    </button>
@endif
{{-- End Insurance --}}


{{-- Languages --}}
@php
if(is_null($article->language) || $article->language == '0') {
    $result= '0';
} else {
    if($article->language == '-1') {
        $result = '-1';
    } elseif($article->language != '1') {
        $language = explode(',', $article->language);
        $result = '';
        foreach ($language_list as $item) {
            if(in_array($item->id, $language)) {
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
@if($result != '-1')
<button type="button" class="swiper-slide {{ $result != '0' ? '' : 'disable' }} btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{!! !is_null($result) ? $result : '' !!}">
    <i class="material-icons">language</i>
    <span class="text">対応言語</span>
</button>
@endif
{{-- Languages --}}
