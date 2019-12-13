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

<div class="{{ !empty($article->object) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <i class="fas fa-chart-line"></i>
        <span class="text d-flex align-items-center ml-2">対象者</span>
    </div>
@empty(!$article->object)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $article->object !!}</span>
    </div>
@endempty
</div>
