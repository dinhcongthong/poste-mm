@extends('user-setting.layouts.master')

@section('stylesheets')
@endsection

@section('content')
<div id="user-summary" class="g-col-4 g-col-md-3">
    <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">
        @isset ($update_success)
        <input type="hidden" id="check-upload-update" value="1">
        @endisset
        @isset ($checkAvatar)
        <input type="hidden" id="check-upload-update" value="1">
        @endisset
        <h4 id="user-acc">Account Infomation</h4>
        <div class="row mt-4">
            <div class="col-auto">
                <p>User ID: <span class="pl-2">{{ Auth::user()->email }}</span></p>
                <p>Phone Number: <span class="pl-2">{{ Auth::user()->phone }}</span></p>
                <p>Password: <span class="pl-2">**...**</span><a href="#" class="ml-2" id="changePW"><em>Change</em></a></p>
                <div class="form-group d-none" id="ipPass">
                    New password: <input type="password" name="password" class="form-control">
                    Confirm new password: <input type="password" name="password_confirm" class="form-control">
                    <a href="#" id="hideInput"><em> Hide</em></a>
                </div>
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <a href="#" class="btn btn-success rounded-pill mr-3 d-none" id="savePW"><i class="far fa-save mr-2"></i>Save Password</a>
                <a href="{{ route('get_view_saved_link') }}" class="btn btn-info rounded-pill mr-3"><i class="fas fa-heart mr-2"></i>Saved Links</a>
                @if (Auth::user()->is_news_letter == 1)
                <a href="#" class="btn btn-secondary rounded-pill" id="subcribe"><i class="fas fa-envelope mr-2"></i>Unsubcribe POSTE</a>
                @else
                <a href="#" class="btn btn-danger rounded-pill" id="subcribe"><i class="far fa-envelope mr-2"></i>Subcribe POSTE</a>
                @endif
            </div>
        </div>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-personal-trading" class="text-primary">個人売買
            <a href="{{ route('get_personal_trading_add_route') }}" class="btn btn-light text-primary float-right">
                <i class="fas fa-plus mr-2"></i>New Ads
            </a>
        </h4>
        <table class="table table-responsive table-hover" id="table_personal">
            <tbody>
                @forelse (Auth::user()->getPersonalTradings as $item)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_personal_trading_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_personal_trading_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary personal" data-id="{{$item->id}}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_personal_trading_add_route') }}" class="btn btn-lg btn-outline-primary mb-4 rounded-pill"><i class="fas fa-plus mr-2"></i>Create New Ads Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{route('get_personal_trading_list_route')}}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-bullboard" class="text-success">情報掲示板
            <a href="{{ route('get_bullboard_add_route') }}" class="btn btn-light text-success float-right">
                <i class="fas fa-plus mr-2"></i>New Ads
            </a>
        </h4>
        <table class="table table-responsive table-hover">
            <tbody>
                @forelse (Auth::user()->getBullBoard as $item)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_bullboard_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_bullboard_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary bullboard" data-id="{{ $item->id }}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_bullboard_add_route') }}" class="btn btn-lg btn-outline-success mb-4 rounded-pill"><i class="fas fa-plus mr-2"></i>Create New Ads Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('get_bullboard_list_route') }}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-job-searching" class="text-danger">お仕事探し
            <a href="{{ route('get_job_searching_add_route') }}" class="btn btn-light text-danger float-right">
                <i class="fas fa-plus mr-2"></i>New Ads
            </a>
        </h4>
        <table class="table table-responsive table-hover">
            <tbody>
                @forelse (Auth::user()->getJobSearching as $item)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_jobsearching_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_job_searching_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary jobSearching" data-id="{{ $item->id }}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_job_searching_add_route') }}" class="btn btn-lg btn-outline-danger mb-4 rounded-pill"><i class="fas fa-plus mr-2"></i>Create New Ads Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('get_job_searching_list_route') }}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-real-estate" class="text-warning">不動産情報
            <a href="{{ route('get_real_estate_add_route') }}" class="btn btn-light text-warning float-right">
                <i class="fas fa-plus mr-2"></i>New Ads
            </a>
        </h4>
        <table class="table table-responsive table-hover">
            <tbody>
                @forelse (Auth::user()->getRealEstate as $item)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_real_estate_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_real_estate_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary realEstate" data-id="{{ $item->id }}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_real_estate_add_route') }}" class="btn btn-lg btn-outline-warning mb-4 rounded-pill"><i class="fas fa-plus mr-2"></i>Create New Ads Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('get_real_estate_list_route') }}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-town">Town Page
            <a href="{{ route('get_town_new_route') }}" class="btn btn-light text-primary float-right">
                <i class="fas fa-plus mr-2"></i>New Page
            </a>
        </h4>
        <table class="table table-responsive table-hover">
            <tbody>
                @forelse (Auth::user()->getTownPage as $key => $item)
                @if ($key < 3)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_town_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary town" data-id="{{$item->id}}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @endif
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_town_new_route') }}" class="btn btn-lg btn-primary mb-4 rounded-pill shadow"><i class="fas fa-plus mr-2"></i>Create New Page Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('get_user_setting_town_index_route') }}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
        <div class="dropdown-divider my-5"></div>
        
        <h4 id="user-business">Business Page
            <a href="{{ route('get_business_new_route') }}" class="btn btn-light text-danger float-right">
                <i class="fas fa-plus mr-2"></i>New Page
            </a>
        </h4>
        <table class="table table-responsive table-hover">
            <tbody>
                @forelse (Auth::user()->getBusinessPage as $key => $item)
                @if($key < 3)
                <tr class="user-table-item">
                    <td class="col text-truncate align-middle">
                        <a href="{{ route('get_business_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                            <i class="fas fa-eye mr-2"></i>
                            {{ $item->name }}
                        </a>
                    </td>
                    <td class="col-auto">
                        <a href="{{ route('get_business_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                    </td>
                    <td class="col-auto">
                        <a href="#" class="nav-link text-secondary business" data-id="{{ $item->id }}"><i class="fas fa-times mr-2"></i></a>
                    </td>
                </tr>
                @endif
                @empty
                <div class="col-12 d-flex flex-wrap justify-content-center align-items-center border rounded bg-grey p-4" style="border-style: dashed !important;">
                    <h2 class="col-12 mt-4 text-center text-black-50">No Item</h2>
                    <a href="{{ route('get_business_new_route') }}" class="btn btn-lg btn-danger mb-4 rounded-pill shadow"><i class="fas fa-plus mr-2"></i>Create New Page Now</a>
                </div>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('get_user_setting_business_index_route') }}" class="btn btn-light btn-block text-secondary"><i class="fas fa-angle-double-down mr-2"></i>See all ads</a>
    </div>
</div>
@endsection
