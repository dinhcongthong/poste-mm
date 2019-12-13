@extends('user-setting.layouts.masterGlobal')

@section('stylesheets')
<style>
    .user-table-item > td:nth-child(2){
        max-width: 20vw;
    }
    .user-table-item > td:nth-child(2) > a{
        white-space: nowrap;
        color: var(--dark);
    }
    .user-table-item > td:nth-child(2) > a:hover{
        color: var(--primary);
    }
    .user-table-item > td:nth-child(2) > a > i{
        display: none;
        color: var(--primary);
    }
    .user-table-item:hover > td:nth-child(2) > a > i{
        display: inline-block;
    }
    #user-town .table .thead-dark th{
        background-color: var(--primary);
        border-color: var(--primary);
        border-bottom: none;
    }
    #user-town .table .thead-dark th:not(:first-of-type), #user-town .table .thead-dark th:not(:last-of-type){
        border-left-color: #dee2e6;
        border-right-color: #dee2e6;
    }
    #empty-town + div{
        display: none;
    }
</style>
@endsection

@section('content')
<div id="user-town" class="g-col-4 g-col-md-3">
    
    <div class="row no-gutters">
        <div class="col-12">
            <h4 id="user-town">
                Town Page
                <a href="{{ route('get_town_new_route') }}" class="btn btn-light text-primary float-right">
                    <i class="fas fa-plus mr-2"></i>New Ads
                </a>
            </h4>
        </div>
        @if(Auth::user()->getTownPage->count() == 0)
        <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
            <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
            <a href="{{ route('get_town_new_route') }}" class="btn btn-lg btn-primary mb-4 rounded-pill shadow"><i class="fas fa-plus mr-2"></i>Create New Page Now</a>
        </div>
        <div class="dropdown-divider mb-5"></div>
        @else
        <div class="col-12 pt-4 table-responsive" id="table-view">
            @include('user-setting.pages.town.table')
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('user-setting/js/seeAll.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
