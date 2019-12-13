@extends('errors.layouts.master')

@section('stysheets')
@php
use App\Models\Category;
use App\Models\AdPosition;

$businessCategoryList = Category::getBusinessCategoryList();
$lifetipCategoryList = Category::getCategoryListFromParam('lifetip', 'category');
$posteTownCategoryList = Category::getCategoryListFromParam('poste-town', 'category');
$dailyinfoCategoryList = Category::getCategoryListFromParam('dailyinfo', 'category');

$ad_home_pc_top_list = AdPosition::getAdListShow(1, 1);
@endphp
@endsection

@section('content')
<div class="content-404 mb-4" style="min-height: calc(100vh - (410px + 187px + 55px)); text-align: center;">
    <h2 class="text-center fw-bolder" style="font-size: 4rem;">
        404 <br/>
        PAGE NOT FOUND
    </h2>
    
    
    <a href="{{ URL::to('/') }}" class="btn btn-lg btn-secondary">Back to Homepage</a>
</div>
@endsection