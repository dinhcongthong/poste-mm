@extends('www.layouts.master')

@section('content')
@include('www.pages.town.header-intro')

<div id="update-section" class="container bg-white my-3 my-lg-4">
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <h4>Choose Category</h4>
            </div>
            <div class="card-body">
                <div class="d-grid g-2 g-lg-4 x3 x4-lg" id="choose-category">
                    @foreach ($posteTownCategoryList as $item)    
                    <a href="{{ route('get_town_new_route').'?category='.$item->slug.'-'.$item->id }}" class="town-item town{{ $loop->index + 2 }} btn btn-light d-flex align-items-center justify-content-center">
                        {{ $item->name }}
                        @if(!empty($item->english_name))
                        {{ ' / '.$item->english_name }}
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection