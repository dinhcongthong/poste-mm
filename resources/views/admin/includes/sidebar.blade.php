{{-- 1. $segment and $segment2 is inherited from Controller.php --}}

<div class="row sticky-top">
    <nav class="navbar navbar-dark bg-dark px-sm-0 w-100">
        <a class="navbar-brand text-white text-center font-weight-bold text-uppercase" href="{{ URL::to('/admin') }}">
            POSTE MYANMAR
        </a>
        <button class="navbar-toggler d-block d-sm-none" type="button" data-toggle="collapse" data-target="#side-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="side-menu">
            <ul class="nav flex-column">
                @php
                $active = false;

                if($segment2 == '') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="#">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>

                @php
                $active = false;

                if($segment2 == 'ads') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" data-toggle="collapse" href="#post-child" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="post-child">
                        <i class="fas fa-chart-bar"></i> Advertisement
                        <i class="fas fa-sort-down float-right"></i>
                    </a>
                    <div class="collapse {{ $active ? 'show' : '' }}" id="post-child" >
                        <ul class="nav flex-column p-0 menu-children">
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $active && $segment2 == 'ads' && $segment3 != 'position' ? 'active' : '' }}" href="{{ route('get_ads_index_ad_route') }}">
                                    Advertisement List
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $active && $segment3 == 'position' ? 'active' : '' }}" href="{{ route('get_ads_position_ad_route') }}">
                                    Ad Position
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @php
                $active = false;

                if($segment2 == 'gallery') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" data-toggle="collapse" href="#gallery-child" role="button" aria-expanded="{{ $active ? 'true' : 'false'}}" aria-controls="post-child">
                        <i class="far fa-image"></i> Gallery
                        <i class="fas fa-sort-down float-right"></i>
                    </a>
                    <div class="collapse {{ $active ? 'show' : '' }}" id="gallery-child" >
                        <ul class="nav flex-column p-0 menu-children">
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $active && $segment3 == '' ? 'active' : '' }}" target="{{ $active ? '_self' : '_blank' }}" href="{{ route('get_gallery_index_ad_route') }}">
                                    Gallery List
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $active && $segment3 == 'add' ? 'active' : '' }}" target="{{ $active ? '_self' : '_blank' }}" href="{{ route('get_gallery_update_ad_route') }}">
                                    Upload photos
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Dailyinfo --}}
                @php
                $active = false;

                if($segment2 == 'dailyinfo') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_dailyinfo_index_ad_route') }}">
                        <i class="fas fa-newspaper"></i> Dailyinfo
                    </a>
                </li>

                {{-- Lifetip --}}
                @php
                $active = false;

                if($segment2 == 'lifetip') {
                    $active = true;
                }

                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_lifetip_index_ad_route') }}">
                        <i class="fas fa-star-of-life"></i> Lifetip
                    </a>
                </li>

                {{-- Business --}}
                @php
                $active = false;

                if($segment2 == 'business') {
                    $active = true;
                }

                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_business_index_ad_route') }}">
                        <i class="fas fa-building"></i> Business
                    </a>
                </li>

                {{-- Poste Town --}}
                @php
                $active = false;

                if($segment2 == 'poste-town') {
                    $active = true;
                }

                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_poste_town_index_ad_route') }}">
                        <i class="fas fa-store"></i> Poste Town
                    </a>
                </li>

                {{-- Golf --}}
                @php
                $active = false;

                if($segment2 == 'golf') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_golf_index_ad_route') }}">
                        <i class="fas fa-golf-ball"></i> Golf
                    </a>
                </li>

                {{-- Golf Shop --}}
                @php
                $active = false;

                if($segment2 == 'golf-shop') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_golf_shop_index_ad_route') }}">
                        <i class="fab fa-shopware"></i> Golf Shop
                    </a>
                </li>

                @php
                $active = false;

                if($segment2 == 'movie' || $segment2 == 'theater' || $segment2 == 'movie-show-time') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" data-toggle="collapse" href="#cinema-child" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="post-child">
                        <i class="fas fa-film"></i> Cinema
                        <i class="fas fa-sort-down float-right"></i>
                    </a>
                    <div class="collapse {{ $active ? 'show' : '' }}" id="cinema-child" >
                        <ul class="nav flex-column p-0 menu-children">
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'movie' ? 'active' : '' }}" href="{{ route('get_movie_index_ad_route') }}">
                                    Movies
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'theater' ? 'active' : '' }}" href="{{ route('get_theater_index_ad_route') }}">
                                    Theaters
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'movie-show-time' ? 'active' : '' }}" href="{{ route('get_showtime_update_ad_route') }}">
                                    ShowTimes
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @php
                $active = false;

                if($segment2 == 'personal-trading' || $segment2 == 'job-searching' || $segment2 == 'real-estate' || $segment2 == 'bull-board') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" data-toggle="collapse" href="#classify-child" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="classify-child">
                        <i class="fab fa-google-wallet"></i> Classifiy Articles
                        <i class="fas fa-sort-down float-right"></i>
                    </a>
                    <div class="collapse {{ $active ? 'show' : '' }}" id="classify-child" >
                        <ul class="nav flex-column p-0 menu-children">
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'personal-trading' ? 'active' : '' }}" href="{{ route('get_personal_trading_index_ad_route') }}">
                                    Personal Trading
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'job-searching' ? 'active' : '' }}" href="{{ route('get_job_searchings_index_ad_route') }}">
                                    Job Searching
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'real-estate' ? 'active' : '' }}" href="{{ route('get_real_estate_index_ad_route') }}">
                                    RealEstate
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'bull-board' ? 'active' : '' }}" href="{{ route('get_bull_board_index_ad_route') }}">
                                    Bullboard
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if(Auth::check() && Auth::user()->type_id == 1)
                @php
                $active = false;

                if($segment2 == 'category' || $segment2 == 'sub-category' || $segment2 == 'param' || $segment2 == 'city' || $segment2 == 'district') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" data-toggle="collapse" href="#miscellaneous-child" role="button" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="post-child">
                        <i class="fas fa-sliders-h"></i> Miscellaneous
                        <i class="fas fa-sort-down float-right"></i>
                    </a>
                    <div class="collapse {{ $active ? 'show' : '' }}" id="miscellaneous-child" >
                        <ul class="nav flex-column p-0 menu-children">
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'category' ? 'active' : '' }}" href="{{ route('get_category_index_ad_route') }}">
                                    Category
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'sub-category' ? 'active' : '' }}" href="{{ route('get_sub_category_index_ad_route') }}">
                                    SubCategory
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'param' ? 'active' : '' }}" href="{{ route('get_param_index_ad_route') }}">
                                    Param
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'city' ? 'active' : '' }}" href="{{ route('get_city_index_ad_route') }}">
                                    City
                                </a>
                            </li>
                            <li class="nav-item seconde-level">
                                <a class="nav-link text-white {{ $segment2 == 'district' ? 'active' : '' }}" href="{{ route('get_district_index_ad_route') }}">
                                    District
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                @php
                $active = false;

                if($segment2 == 'customer') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_customer_index_ad_route') }}">
                        <i class="fas fa-users"></i> Customer
                    </a>
                </li>

                @php
                $active = false;

                if($segment2 == 'user') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_user_index_ad_route') }}">
                        <i class="fas fa-user"></i> User
                    </a>
                </li>

                @if(Auth::check() && Auth::user()->type_id == 1)
                @php
                $active = false;

                if($segment2 == 'setting') {
                    $active = true;
                }
                @endphp
                <li class="nav-item first-level {{ $active ? 'active' : '' }}">
                    <a class="nav-link text-white" href="{{ route('get_setting_index_ad_route') }}">
                        <i class="fas fa-cogs"></i> Setting
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
