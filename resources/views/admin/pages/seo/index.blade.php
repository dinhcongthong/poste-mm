@extends('admin.layouts.master')

@section('stylesheets')
<style>
    .badge {
        padding: 0.3rem 0.5rem;
        font-size: 1rem;
    }
</style>
@endsection

@section('content')
<div class="row no-gutters py-2">
    <a href="{{ route('get_seo_meta_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
</div>
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        <table class="datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Link</th>
                    <th>Info</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
