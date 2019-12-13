@extends('user-setting.layouts.masterGlobal')

@section('stylesheets')
<style>
    .user-table-item > td:nth-child(2){
        max-width: 25vw;
    }
    .user-table-item > td:nth-child(2) > a{
        white-space: nowrap;
        color: var(--dark);
    }
    .user-table-item > td:nth-child(2) > a:hover{
        color: var(--info);
    }
    .user-table-item > td:nth-child(2) > a > i{
        display: none;
        color: var(--info);
    }
    .user-table-item:hover > td:nth-child(2) > a > i{
        display: inline-block;
    }
    #user-business .table .thead-dark th{
        background-color: var(--danger);
        border-color: var(--danger);
        border-bottom: none;
    }
    #user-business .table .thead-dark th:not(:first-of-type), #user-town .table .thead-dark th:not(:last-of-type){
        border-left-color: #dee2e6;
        border-right-color: #dee2e6;
    }
    #empty-business + div{
        display: none;
    }
</style>
@endsection

@section('content')
<div id="user-business" class="g-col-4 g-col-md-3">
    
    <div class="row no-gutters">
        <div class="col-12">
            <h4 id="user-business">
                Business Page
                <a href="{{ route('get_business_new_route') }}" class="btn btn-light text-danger float-right">
                    <i class="fas fa-plus mr-2"></i>New Ads
                </a>
            </h4>
        </div>
        @if(Auth::user()->getBusinessPage->count() == 0)
        <div id="empty-business" class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
            <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
            <a href="{{ route('get_business_new_route') }}" class="btn btn-lg btn-danger mb-4 rounded-pill shadow"><i class="fas fa-plus mr-2"></i>Create New Page Now</a>
        </div>
        <div class="dropdown-divider mb-5"></div>
        @else
        <div class="col-12 pt-4 table-responsive" id="table-view">
            @include('user-setting.pages.business.table')
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('user-setting/js/seeAll.js') }}"></script>
<script>
    $('.business-active').addClass("active");
</script>
@endsection
