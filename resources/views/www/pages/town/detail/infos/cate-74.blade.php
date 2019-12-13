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

<div class="{{ !empty($article->department) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <span class="icon d-flex align-items-center ml-2">診療科</span>
    </div>
@empty(!$article->department)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $article->department !!}</span>
    </div>
@endempty
</div>

@if(is_null($article->insurance) || $article->insurance == 0)
<div class="span-color">
    <div class="d-flex">
        <span class="icon d-flex align-items-center ml-2">キャッシュレス対応</span>
    </div>
</div>
@else
@if($article->insurance != '-1')
    <div class="text-primary">
        <div class="d-flex">
            <span class="icon d-flex align-items-center ml-2">キャッシュレス対応</span>
        </div>
    </div>
@endif
@endif

@php
if(is_null($article->language)) {
    $result = null;
} else {
    if($article->language != '0') {
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
<div class="{{ !is_null($result) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <i class="material-icons">language</i>
        <span class="text d-flex align-items-center ml-2">対応言語</span>
    </div>
@empty(!$result)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $result !!}</span>
    </div>
@endempty
</div>
