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
