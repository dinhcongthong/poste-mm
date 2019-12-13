<div class="d-grid x1 x2-md x1-lg g-2">
    <a href="{{ route('get_personal_trading_add_route') }}" class="btn btn-primary w-100" title="新規投稿"><i class="fas fa-pencil-alt"></i> 新規投稿</a>
    <a href="{{ route('get_personal_trading_list_route') }}" class="btn btn-outline-secondary w-100" title="削除・変更">削除・変更</a>
</div>
<div class="seperate"></div>
<div class="d-lg-none">
    <a href="#filter" data-toggle="collapse" class="btn btn-outline-secondary btn-block" title="filter">Filter</a>
</div>
<div class="collapse d-lg-none mt-3" id="filter">
    <div class="type-option">
        <h3>売り買い別表示</h3>
        <ul>
            @foreach ($personalTypeList as $item)     
            <li>
                <a href="{{ route('get_personal_trading_type_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->value }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>ジャンル別表示</h3>
        <ul>
            @foreach ($productCategoryList as $item)    
            <li>
                <a href="{{ route('get_personal_trading_category_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="d-none d-lg-block">
    <div class="type-option">
        <h3>売り買い別表示</h3>
        <ul>
            @foreach ($personalTypeList as $item)     
            <li>
                <a href="{{ route('get_personal_trading_type_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->value }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>ジャンル別表示</h3>
        <ul>
            @foreach ($productCategoryList as $item)    
            <li>
                <a href="{{ route('get_personal_trading_category_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>