@extends('www.pages.personal-trading.master')

@section('personal-content')    
<h3 class="title">最新情報一覧</h3>
<ul class="list">
    @foreach ($articleList as $item)       
    <li>
        <a href="{{ route('get_personal_trading_detail_route', $item->slug.'-'.$item->id) }}" title="asdf">
            <div class="row py-2 list-item">
                <div class="col-5 pr-1">
                    <span class="type {{ $item->type_id == 20 ? 'type-sell' : 'type-buy'}} pr-lg-2 mb-2 mb-lg-0 d-block d-md-inline-block">{{ $item->type->value }}</span>
                    <span class="pr-lg-2 text-dark mb-2 mb-lg-0 d-block d-md-inline-block">{{ date('Y-m-d', strtotime($item->updated_at)) }}</span>
                    <span class="d-block d-lg-inline-block type-category">{{ $item->category->name }}</span>
                </div>
                <div class="col-7 pl-1 text-dark">
                    {{ $item->name }}
                </div>
            </div>
        </a>
    </li>
    @endforeach
</ul>
<div class="paginate-area">
    {{ $articleList->links() }}
</div>
@endsection