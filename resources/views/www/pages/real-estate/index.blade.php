@extends('www.pages.real-estate.master')

@section('real-content')
<h3 class="title">最新情報一覧</h3>
<ul class="list">
    @foreach ($articleList as $item)
    <li>
    <a href="{{ route('get_real_estate_detail_route', $item->slug.'-'.$item->id) }}" title="asdf">
            <div class="row py-2 list-item">
                <div class="col-6 pr-1 estate">
                    <div class="row">
                        <div class="col-12 col-md-6 pr-2 mb-1">
                            <span class="type {{ $item->type->id == 115 ? 'type-share' : ($item->type->id == 116 ? 'type-borrow' : 'type-lend') }} m-0 d-inline-block w-100">{{ $item->type->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 px-md-2 mb-1 text-center">
                            <span class="text-dark mb-2">{{ !is_null($item->city) ? $item->city->name : '' }}</span>
                        </div>
                        <div class="col-12 col-md-6 px-md-2 text-center mb-1 mb-lg-0">
                            <span class="pl-2 d-block d-lg-inline-block type-category text-dark font-weight-bold">{{ $item->price->name }} </span>
                        </div>
                        <div class="col-12 col-md-6 px-md-2 text-center">
                            {{ $item->category->name }}
                        </div>
                    </div>
                </div>
                <div class="col-6 pl-3 text-dark d-flex flex-wrap align-items-center">
                    {{ $item->name }}
                </div>
            </div>
        </a>
    </li>
    @endforeach
</ul>
@endsection