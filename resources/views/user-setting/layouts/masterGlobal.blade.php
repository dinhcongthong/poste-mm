<!DOCTYPE html>
<html lang="ja-jp">
<meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】" />
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="ミャンマー,ヤンゴン,治安,料理,言語,通貨,物価,首都,人,ミャンマー語,英語,旅行" />




    <meta property="og:url" content="https://poste-mm.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="ヤンゴンの生活情報サイトPOSTE｜ミャンマー生活の新基準" />
    <meta property="og:description" content="ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】" />
    <meta property="og:image" content="https://poste-mm.com/images/poste/logo.png" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/poste/favicon.ico') }}">

    {{--  link css user-setting file --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('user-setting/css/main.css') }}">

    <title>{{ isset($pageTitle) ? $pageTitle : '' }} | Admin Dashboard</title>

    {{-- Bootstrap 4.2.1 CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    {{-- FontAwesome 5.3.1 --}}
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    {{-- DataTable CSS 1.10.19 --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendors/datatables/datatables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/datatables/plugins/css/dataTables.bootstrap4.min.css') }}">
    {{-- Animate CSS --}}
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    {{-- Select 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2.min.css') }}">
    {{-- Bootstrap4 Dialog --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-dialog/css/bootstrap-dialog.min.css') }}">
    {{-- Bootstrap4 Datetimepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c:100,300,400,500,700,800,900&amp;subset=japanese,vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,800,900|Roboto+Condensed:100,300,400,500,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://poste-mm.com/www/css/main.css">
    <link rel="stylesheet" type="text/css" href="https://poste-mm.com/www/css/grid.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('www/css/user.css') }}">

    {!! isset($stylesheets) ? $stylesheets : '' !!}

    @yield('stylesheets')
</head>
<body class="user-global">
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div id="user-header" class="row">
            <div class="container">
                <div class="row align-items-center pt-4 pt-sm-5 px-4 px-sm-3">
                    <div class="col-12 col-sm-auto p-0 mb-3 mb-sm-5 text-center">
                        <a href="{{ url('/account-setting') }}" class="nav-link text-secondary h5 m-0 p-0"><i class="fas fa-angle-left mr-2"></i>Back to DASHBOARD</a>
                    </div>
                    <div class="col-12 col-sm p-0 mb-3 mb-sm-5 d-flex justify-content-center justify-content-sm-end">
                        <div class="dropdown border-right p-0 pr-3">
                            <a href="#" class="btn btn-outline-light text-dark border-0 rounded-pill dropdown-toogle d-flex align-items-center" role="button" id="accButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media-wrapper rounded-circle border mr-2" style="width:2.5rem; height:2.5rem;">
                                    @php
                                    $thumbnail = Auth::user()->getThumb;
                                    @endphp
                                    <img class="img-responsive mh-100 m-auto img-map-preview" alt="Primary map Image" src="{{ empty($thumbnail) ? asset('images/poste/no-image-6x4.png') : App\Models\Base::getUploadURL($thumbnail->name, $thumbnail->dir) }}">
                                </div>
                                {{ getUsername(Auth::user()) }} さん
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accButton">
                                <a href="{{ url('/account-setting/edit-profile') }}" class="dropdown-item"><i class="far fa-user mr-2"></i>Edit your profile</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/account-setting/saved-link') }}" class="dropdown-item"><i class="far fa-heart mr-2"></i>Your saved links</a>
                            </div>
                        </div>
                        <div class="dropdown flex-shrink-1 d-flex align-items-center justify-content-center">
                            <button class="btn btn-outline-light text-dark border-0 rounded-circle dropdown-toogle new-noti" type="button" id="notiButton" data-toggle="dropdown" noti-counter="{{ $notify_list->where('status', 0)->count() }}" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-bell" style="font-size:1.75rem; opacity:.8;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0 rounded-lg overflow-hidden shadow-lg" aria-labelledby="notiButton">
                                <!-- ///////////// -->
                                <div class="dropdown-item bg-dark border-bottom text-white p-0 d-flex align-items-center">
                                    <h6 class="flex-grow-1 m-0 px-3 py-2">NOTIFICATIONS</h6>
                                    <a class="text-right text-light small flex-shrink-1 m-0 px-3 py-2" href="#" id="read-all">Mark all as read</a>
                                </div>

                                <div class="dropdown-item p-0 list-group list-group-flush noti-list">
                                    @forelse ($notify_list as $key => $item)
                                        @if($item->type_id == App\Models\PosteNotification::TYPE_FEEDBACK && $key <= 9)
                                            <a class="list-group-item list-group-item-action noti {{ $item->status == 1 ? "noti-seen" : '' }}" href="{{ route('get_detail_notification_route', $item->id) }}">
                                                <span class="font-weight-bold">{{ $item->name }}</span> has left a feedback on your "<span class="font-weight-bold">{{ !is_null($item->getType()['type']) ? $item->getType()['type']->name : 'Deleted by Owner' }}</span>" page.
                                                <br>
                                                <small style="color:#a9a9a9;">Sent at {{ $item->created_at }}</small>
                                            </a>
                                        @endif
                                    @empty
                                        <p class="noti-no">No Unread Message</p>
                                    @endforelse
                                </div>
                                <a class="dropdown-item text-center text-primary border-top noti-all" href="{{ route('get_notification_route') }}">See all </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="user-management" class="row flex-grow-1">
            <div class="container px-0 px-sm-3">
                <div class="d-grid x3 x4-lg g-4 wrapper shadow p-4">
                    @include('user-setting.includes.sidebar')
                    @yield('content')
                </div>
            </div>
        </div>

        <div id="user-sidebar-mobile" class="row navbar bg-light border-top list-group d-lg-none p-0">
            <ul class="nav nav-pills nav-justified w-100 h-100 d-grid x4 xr1">
                <li class="nav-item acc-active">
                    <a id="acc-info" class="nav-link  {{ Request()->segment(2) == 'edit-profile' ? 'active' : '' }}" href="{{ route('get_user_profile_edit_route') }}">
                        <i class="fas fa-user"></i>
                        Account
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropup w-100 d-flex align-items-center justify-content-center">
                        <a class="nav-link dropdown-toogle" id="cl-m-btn" href="#user-classified" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bullhorn"></i>
                            Classified
                        </a>
                        <div class="dropdown-menu" aria-labelledby="cl-m-btn">
                            <a class="dropdown-item" href="{{ route('get_personal_trading_list_route')}}">
                                <i class="fas fa-bullhorn"></i>
                                Personal Trading
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('get_real_estate_list_route') }}">
                                <i class="fas fa-city"></i>
                                Real Estate
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('get_job_searching_list_route') }}">
                                <i class="fas fa-search-dollar"></i>
                                Job Searching
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('get_bullboard_list_route') }}">
                                <i class="fas fa-chart-bar"></i>
                                Bullboard
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item town-active">
                    <a id="town-info" class="nav-link {{ Request()->segment(2) == 'town' ? 'active' : '' }}" href="{{ route('get_user_setting_town_index_route') }}">
                        <i class="far fa-thumbs-up"></i>
                        Town
                    </a>
                </li>
                <li class="nav-item business-active">
                    <a id="business-info" class="nav-link {{ Request()->segment(2) == 'business' ? 'active' : '' }}" href="{{ route('get_user_setting_business_index_route') }}">
                        <i class="fas fa-briefcase"></i>
                        Business
                    </a>
                </li>
            </ul>
        </div>

        <div id="user-footer" class="row">
            <div class="container">
                <p class="text-center my-5">
                    Poste Company Limited.<br>
                    Copyright 2019. All Right Reserved.
                </p>
            </div>
        </div>

    </div>



    @include('auth.logout-form')

    {{-- Jquery --}}
    <script type="text/javascript" src="{{ asset('vendors/jquery/jquery-3.3.1.min.js') }}"></script>
    {{-- Popperjs for BS4 --}}
    <script src="{{ asset('js/popper.min.js') }}"></script>
    {{-- BS4 --}}
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- FontAwesome 5.3.1 --}}
    {{-- <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script> --}}
    {{-- DataTables --}}
    <script src="{{ asset('vendors/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/plugins/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
    {{-- Bootstrap4 Dialog --}}
    <script src="{{ asset('vendors/bootstrap4-dialog/js/bootstrap-dialog.min.js') }}"></script>
    {{-- MomentJs --}}
    <script src="{{ asset('js/moment.min.js') }}"></script>
    {{-- Bootstrap4 Datetimepicker --}}
    <script src="{{ asset('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    {{-- CKEditor --}}
    <script src="{{ asset('vendors/ckeditor4/ckeditor.js') }}"></script>

    <script>
    var base_url = "{{ URL::to('/') }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    </script>
    <script src="https://poste-mm.com/vendors/lining/lining.js"></script>

    <script src="https://poste-mm.com/vendors/swiper/js/swiper.min.js"></script>

    <script src="http://localhost/poste-mm/public/vendors/datatables/datatables.min.js"></script>

    <script src="http://localhost/poste-mm/public/vendors/datatables/plugins/js/jquery.dataTables.min.js"></script>

    <script src="http://localhost/poste-mm/public/vendors/datatables/plugins/js/dataTables.bootstrap4.min.js"></script>

    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script src="{{ asset('user-setting/js/main.js') }}"></script>
    <script>
    $('#notification').addClass('d-none');
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    {!! isset($scripts) ? $scripts : '' !!}

    @yield('scripts')
</body>
</html>
