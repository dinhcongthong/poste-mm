@extends('www.pages.bullboard.master')

@section('bullboard-content')
<h3 class="title">最新情報一覧</h3>
<ul class="list">
    @foreach ($articleList as $item)    
    <li>
    <a href="{{ route('get_bullboard_detail_route', $item->slug.'-'.$item->id) }}" title="asdf">
            <div class="row py-2 list-item">
                <div class="col-5 pr-1">
                    <div class="row">
                        <div class="col-12 col-md-6 pr-2 mb-1">
                            <span class="type type-bullboard m-0 d-inline-block w-100">{{ $item->category->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 px-md-2 mb-1 text-center">
                            <span class="text-dark mb-2">{{ date('Y-m-d', strtotime($item->updated_at)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-7 pl-3 text-dark d-flex flex-wrap align-items-center">
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