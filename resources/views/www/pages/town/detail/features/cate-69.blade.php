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

{{-- Smoking --}}
<button type="button" class="swiper-slide btn btn-light {{ is_null($article->smoking) ? 'disable' : '' }}" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ !empty($article->smoking) ? $article->smoking : '' }}">
    @if(!is_null($article->smoking))
    <i class="material-icons">smoking_rooms</i>
    @else
    <i class="material-icons">smoke_free</i>
    @endif
    <span class="text">喫煙</span>
</button>
{{-- End Smoking --}}
