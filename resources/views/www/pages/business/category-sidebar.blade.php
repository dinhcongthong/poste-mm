@foreach ($businessCategoryList as $item)
    @php
    $childList = $item->getChildrenCategory;

    $article_ids = $childList->reduce(function($total, $child) {
        return $total = array_merge($total, $child->getBusinesses->pluck('id')->toArray());
    }, array());

    $article_ids = array_unique($article_ids);
@endphp
<p class="m-0 d-flex align-items-center parent-cate">
    <a class="w-75 text-dark bg-light font-weight-bold nav-link" href="{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}">
        {{ $item->name }}
        @if( count($article_ids) > 0)
            <span class="badge badge-danger badge-pill">{{ count($article_ids) }}</span>
        @endif
    </a>
    <a class="w-25 nav-link collapsed bg-light btn-dropdown ml-auto" data-toggle="collapse" href="#cate-{{$item->id}}" role="button" aria-expanded="false" aria-controls="cate-{{$item->id}}">
    </a>
</p>
<div class="collapse px-3" id="cate-{{$item->id}}">
    @foreach ($childList as $child)
        @php
        $total = $child->getBusinesses->count();
        @endphp
        <a class="nav-link text-danger" href="{{ route('get_business_category_route', $child->slug.'-'.$child->id) }}">
            {{ $child->name }}
            @if($total > 0)
                <span class="sub-article-num">
                    {{ $total }}
                </span>
            @endif
        </a>
    @endforeach
</div>
@if(!$loop->last)
    <div class="dropdown-divider"></div>
@endif
@endforeach
