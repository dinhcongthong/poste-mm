@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <a href="{{ route('get_theater_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
</div>

<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        @include('admin.pages.cinema.theater-table')
    </div>
</div>
@endsection