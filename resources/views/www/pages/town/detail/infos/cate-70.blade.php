<div class="{{ !empty($article->check_in) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <span class="icon d-flex align-items-center ml-2">チェックイン時間</span>
    </div>
@empty(!$article->check_in)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $article->check_in !!}</span>
    </div>
@endempty
</div>

<div class="{{ !empty($article->check_out) ? 'text-primary' : 'span-color' }}">
    <div class="d-flex">
        <span class="icon d-flex align-items-center ml-2">チェックアウト時間</span>
    </div>
@empty(!$article->check_out)
    <div class="feature-detail">
        <span class="text-dark d-flex align-items-center"> {!! $article->check_out !!}</span>
    </div>
@endempty
</div>

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

@if(is_null($article->shuttle) || $article->shuttle == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">airport_shuttle</i>
            <span class="text d-flex align-items-center ml-2">送迎</span>
        </div>
    </div>
@else
@if($article->shuttle != '-1')
    <div class="text-primary">
        <div class="d-flex">
            <i class="material-icons">airport_shuttle</i>
            <span class="text d-flex align-items-center ml-2">送迎</span>
        </div>
    </div>
@endif
@endif

@if(is_null($article->laundry) || $article->laundry == '0')
    <div class="text-primary">
        <div class="d-flex">
            <i class="material-icons">local_laundry_service</i>
            <span class="text d-flex align-items-center ml-2">ランドリー</span>
        </div>
    </div>
@else
@if($article->laundry != '-1')
<div class="text-primary">
    <div class="d-flex">
        <i class="material-icons">local_laundry_service</i>
        <span class="text d-flex align-items-center ml-2">ランドリー</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->air_condition) || $article->air_condition == '0')\
    <div class="span-color">
        <div class="d-flex">
            <span class="icon d-flex align-items-center ml-2">冷暖房</span>
        </div>
    </div>
@else
@if($article->air_condition != '-1')
<div class="text-primary">
    <div class="d-flex">
        <span class="icon d-flex align-items-center ml-2">冷暖房</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->kitchen) || $article->kitchen == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">kitchen</i>
            <span class="text d-flex align-items-center ml-2">キッチン</span>
        </div>
    </div>
@else
@if($article->kitchen != '-1')
<div class="text-primary">
    <div class="d-flex">
        <i class="material-icons">kitchen</i>
        <span class="text d-flex align-items-center ml-2">キッチン</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->tv) || $article->tv == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="material-icons">tv</i>
            <span class="text d-flex align-items-center ml-2">テレビ</span>
        </div>
    </div>
@else
@if($article->tv != '-1')
<div class="text-primary">
    <div class="d-flex">
        <i class="material-icons">tv</i>
        <span class="text d-flex align-items-center ml-2">テレビ</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->shower) || $article->shower == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="fas fa-shower"></i>
            <span class="text d-flex align-items-center ml-2">シャワー</span>
        </div>
    </div>
@else
@if($article->shower != '-1')
<div class="text-primary">
    <div class="d-flex">
        <i class="fas fa-shower"></i>
        <span class="text d-flex align-items-center ml-2">シャワー</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->bathtub) || $article->bathtub == '0')
    <div class="span-color">
        <div class="d-flex">
            <i class="fas fa-bath"></i>
            <span class="text d-flex align-items-center ml-2">浴槽</span>
        </div>
    </div>
@else
@if($article->bathtub != '-1')
<div class="text-primary">
    <div class="d-flex">
        <i class="fas fa-bath"></i>
        <span class="text d-flex align-items-center ml-2">浴槽</span>
    </div>
</div>
@endif
@endif

@if(is_null($article->luggage) || $article->luggage == '0')
    <div class="span-color" style="grid-column-start: 2;">
        <div class="d-flex">
            <i class="fas fa-luggage-cart"></i>
            <span class="text d-flex align-items-center ml-2">荷物預かり</span>
        </div>
    </div>
@else
@if($article->luggage != '-1')
<div class="text-primary" style="grid-column-start: 2;">
    <div class="d-flex">
        <i class="fas fa-luggage-cart"></i>
        <span class="text d-flex align-items-center ml-2">荷物預かり</span>
    </div>
</div>
@endif
@endif
