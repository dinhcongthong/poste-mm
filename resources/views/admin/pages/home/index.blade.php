@extends('admin.layouts.master')

@section('content')
<div class="col-xs-12 py-4">
    <div class="col-xs-12 col-md-12">

        <h2 class="border border-top-0 border-left-0 border-right-0 border-dark mb-4">
            Nearly Expiration
        </h2>

        <div class="card mb-4">
            <div class="card-header">
                Nearly expiration Town
                <a href="{{ route('get_ads_index_ad_route') }}" class="float-right">Ads Management</a>
            </div>
            <div class="card-body" style="font-size: .9rem;">
                <ul style="padding: 0px;">
                    <li class="header" style="list-style:none; font-weight:bold; display: flex;">
                        <div class="col-xs-12 col-md-1">
                            ID
                        </div>
                        <div class="col-xs-12 col-md-4">
                            Name
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Position
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Available Days
                        </div>
                    </li>
                    <li class="ads-home" id="article" style="list-style: none; ">
                        @foreach($ad_remain_list as $item)
                        @include('admin.pages.home.ad_expiration')
                        @endforeach
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                Nearly expiration Town
                <a href="{{ route('get_poste_town_index_ad_route') }}" class="float-right">Town Management</a>
            </div>
            <div class="card-body" style="font-size: .9rem;">
                <ul style="padding: 0px;">
                    <li class="header" style="list-style:none; font-weight:bold; display: flex;">
                        <div class="col-xs-12 col-md-1">
                            ID
                        </div>
                        <div class="col-xs-12 col-md-4">
                            Name
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Author
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Available Days
                        </div>
                    </li>
                    <li class="ads-home" id="article" style="list-style: none; ">
                            @foreach($town_remain_list as $item)
                            @include('admin.pages.home.data-section-admin')
                            @endforeach
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Nearly expiration Business
                    <a href="{{ route('get_business_index_ad_route') }}" class="float-right">Business Management</a>
            </div>
            <div class="card-body">
                <ul style="padding: 0px;">
                    <li class="header" style="list-style:none; font-weight:bold; display: flex;">
                        <div class="col-xs-12 col-md-1">
                            ID
                        </div>
                        <div class="col-xs-12 col-md-4">
                            Name
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Author
                        </div>
                        <div class="col-xs-12 col-md-2">
                            Available Days
                        </div>
                    </li>
                    <li class="ads-home" id="article" style="list-style: none; ">
                        @foreach($business_remain_list as $item)
                        @include('admin.pages.home.data-section-admin')
                        @endforeach
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
