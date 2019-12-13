@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    @if($type == 'golf-shop')
    <a href="{{ route('get_golf_shop_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
    @else
    <a href="{{ route('get_golf_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
    @endif
</div>
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        @include('admin.pages.golf.table')
    </div>
</div>
@endsection
