<div class="p-4">
    <div class="d-grid x2 x3-md g-4">
        @switch($article->category_id)
            @case(68)
            @include('www.pages.town.detail.infos.cate-68')
            @break
            @case(69)
            @case(71)
            @case(75)
            @include('www.pages.town.detail.infos.cate-69')
            @break
            @case(70)
            @include('www.pages.town.detail.infos.cate-70')
            @break
            @case(72)
            @include('www.pages.town.detail.infos.cate-72')
            @break
            @case(74)
            @include('www.pages.town.detail.infos.cate-74')
            @break
            @case(76)
            @include('www.pages.town.detail.infos.cate-76')
            @break
            @case(77)
            @include('www.pages.town.detail.infos.cate-77')
            @break
            @case(78)
            @include('www.pages.town.detail.infos.cate-78')
            @break
            @default

        @endswitch
    </div>
</div>
