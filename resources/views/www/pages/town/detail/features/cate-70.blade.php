{{-- Check in --}}
<button type="button" class="swiper-slide btn btn-light {{ !empty($article->check_in) ? '' : 'disable' }}" data-toggle="tooltip" data-placement="bottom" data-html="true"  title="{{ !empty($article->check_in) ? $article->check_in : '' }}">
    <span class="icon {{ !empty($article->check_in) ? 'text-primary' : '' }}">チェックイン時間</span>
</button>
{{-- End Check in --}}

{{-- Check out --}}
<button type="button" class="swiper-slide btn btn-light {{ !empty($article->check_out) ? '' : 'disable' }}" data-toggle="tooltip" data-placement="bottom" data-html="true"  title="{{ !empty($article->check_out) ? $article->check_out : '' }}">
    <span class="icon {{ !empty($article->check_out) ? 'text-primary' : '' }}">チェックアウト時間</span>
</button>
{{-- End Check out --}}

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

{{-- Breakfast --}}
@if(is_null($article->breakfast) || $article->breakfast == '0')
<button type="button" class="swiper-slide btn btn-light disable" data-toggle="tooltip" data-placement="bottom" data-html="true">
    <i class="material-icons">free_breakfast</i>
    <span class="text">朝食</span>
</button>
@else
@if($article->breakfast != '-1')
    <button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $article->breakfast != '1' ? $article->breakfast : '' }}">
        <i class="material-icons">free_breakfast</i>
        <span class="text">朝食</span>
    </button>
@endif
@endif
{{-- End Breakfast --}}


{{-- Shuttle --}}
@if(is_null($article->shuttle) || $article->shuttle == '0')
<button type="button" class="swiper-slide btn btn-light disable">
    <i class="material-icons">airport_shuttle</i>
    <span class="text">送迎</span>
</button>
@else
@if($article->shuttle != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="material-icons">airport_shuttle</i>
        <span class="text">送迎</span>
    </button>
@endif
@endif
{{-- End Shuttle --}}

{{-- Laundry --}}
@if(is_null($article->laundry) || $article->laundry == '0')
<button type="button" class="swiper-slide btn btn-light disable" data-toggle="tooltip" data-placement="bottom" data-html="true">
    <i class="material-icons">local_laundry_service</i>
    <span class="text">ランドリー</span>
</button>
@else
@if($article->laundry != '-1')
    <button type="button" class="swiper-slide btn btn-light" data-toggle="tooltip" data-placement="bottom" data-html="true" title="{{ $article->laundry != '1' ? $article->laundry : '' }}">
        <i class="material-icons">local_laundry_service</i>
        <span class="text">ランドリー</span>
    </button>
@endif
@endif
{{-- End Laundry --}}

{{-- Air Condition --}}
@if(is_null($article->air_condition) || $article->air_condition == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <span class="icon">冷暖房</span>
    </button>
@else
@if($article->air_condition != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <span class="icon text-primary">冷暖房</span>
    </button>
@endif
@endif
{{-- End Air Condition --}}

{{-- Kitchen --}}
@if(is_null($article->kitchen) || $article->kitchen == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <i class="material-icons">kitchen</i>
        <span class="text">キッチン</span>
    </button>
@else
@if($article->kitchen != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="material-icons">kitchen</i>
        <span class="text">キッチン</span>
    </button>
@endif
@endif
{{-- End Kitchen --}}

{{-- TV --}}
@if(is_null($article->tv) || $article->tv == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <i class="material-icons">tv</i>
        <span class="text">テレビ</span>
    </button>
@else
@if($article->tv != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="material-icons">tv</i>
        <span class="text">テレビ</span>
    </button>
@endif
@endif
{{-- End TV --}}

{{-- Shower --}}
@if(is_null($article->shower) || $article->shower == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <i class="fas fa-shower"></i>
        <span class="text">シャワー</span>
    </button>
@else
@if($article->shower != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="fas fa-shower"></i>
        <span class="text">シャワー</span>
    </button>
@endif
@endif
{{-- End Shower --}}

{{-- Bathtub --}}
@if(is_null($article->bathtub) || $article->bathtub == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <i class="fas fa-bath"></i>
        <span class="text">浴槽</span>
    </button>
@else
@if($article->bathtub != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="fas fa-bath"></i>
        <span class="text">浴槽</span>
    </button>
@endif
@endif
{{-- End Bathtub --}}

{{-- luggage --}}
@if(is_null($article->luggage) || $article->luggage == '0')
    <button type="button" class="swiper-slide btn btn-light disable">
        <i class="fas fa-luggage-cart"></i>
        <span class="text">荷物預かり</span>
    </button>
@else
@if($article->luggage != '-1')
    <button type="button" class="swiper-slide btn btn-light">
        <i class="fas fa-luggage-cart"></i>
        <span class="text">荷物預かり</span>
    </button>
@endif
@endif
{{-- End luggage --}}
