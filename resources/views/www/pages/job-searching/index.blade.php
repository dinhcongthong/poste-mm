@extends('www.pages.job-searching.master')

@section('jobsearching-content')
<h3 class="title">最新情報一覧</h3>
<ul class="list">
    @forelse ($articleList as $item)
        <li>
        <a href="{{ route('get_jobsearching_detail_route', $item->slug.'-'.$item->id) }}">
            <div class="row py-2 list-item">
                <div class="col-12 col-md-3 pr-lg-1 mb-1 mb-lg-0">
                    <span class="type type-job pr-lg-2 mb-2 mb-lg-0 d-block">{{ $item->type->name }}</span>
                </div>
                <div class="col-12 col-md-4 px-lg-1 mb-1 mb-lg-0">
                    <span class="type type-buy text-dark">{{ $item->category->name }}</span> {{ $item->name }}
                </div>
                <div class="col-12 col-md-4 pl-lg-1 text-dark">
                    <span class="type type-buy">給料</span> {{ $item->salary }}
                </div>
            </div>
        </a>
    </li>
    @empty
        <li class="text-center">NO DATA</li>
    @endforelse
</ul>
@endsection