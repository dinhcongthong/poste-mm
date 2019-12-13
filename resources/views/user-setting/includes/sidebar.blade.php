<div id="user-profile" class="g-col-4 d-flex flex-wrap py-3">
    <div class="col-12 col-md mb-4 mb-md-0">
        <div class="row">
            <div class="col-5 col-md-3">
                <div class="media-wrapper-1x1 bg-light border rounded-circle" style="cursor: pointer;">
                    <div class="avatar d-flex align-items-center justify-content-center">
                        @php
                        $thumbnail = Auth::user()->getThumb;
                        @endphp
                        <img class="img-cover" alt="Primary map Image" src="{{ empty($thumbnail) ? asset('images/poste/no-image-6x4.png') : App\Models\Base::getUploadURL($thumbnail->name, $thumbnail->dir) }}">
                    </div>
                    <div class="avatar-form d-flex align-items-end">
                        <form action="{{ route('post_upload_avatar_route') }}" method="POST" id="form_avatar" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="avatar-btn custom-file bg-secondary text-center" style="top:auto;">
                                <input type="file" class="pointer custom-file-input" id="inputGroupFile02" name="avatar">
                                <span style="position:absolute;top:0;bottom:0;right:0;left:0;text-align:center; display: flex; align-items: center; justify-content: center; color:#fff;">Change</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-7 col-md d-flex flex-column justify-content-center">
                <h3 class="fw-bold m-0 flex-grow-1 d-flex flex-column justify-content-center" style="font-size: 1.5rem;">
                    <span class="h6">こんにちわ</span><br>{{ getUsername(Auth::user()) }}さん
                </h3>
                <a href="{{ route('get_user_profile_edit_route') }}" class="btn btn-outline-secondary btn-sm rounded-pill align-self-start flex-shrink-1">Edit your profile</a>
            </div>
        </div>
    </div>
    <div class="dropdown col-12 col-md-2 d-flex ml-auto align-items-center justify-content-center" id="notification">
        <button class="btn btn-light rounded-circle dropdown-toogle new-noti" type="button" id="notiButton" title="Notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" noti-counter="{{ $notify_list->where('status', 0)->count() }}">
            <i class="far fa-bell" style="font-size:2.5rem; opacity:.8;"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right p-0 rounded-lg overflow-hidden shadow-lg" aria-labelledby="notiButton">
            <!-- ///////////// -->
            <div class="dropdown-item bg-dark text-white p-0 d-flex align-items-center">
                <h6 class="flex-grow-1 m-0 px-3 py-2">NOTIFICATIONS</h6>
                <a class="text-right text-light small flex-shrink-1 m-0 px-3 py-2" href="#" id="read-all">Mark all as read</a>
            </div>

            <div class="dropdown-item p-0 list-group list-group-flush noti-list">
                @forelse ($notify_list as $key => $item)
                    @if($item->type_id == App\Models\PosteNotification::TYPE_FEEDBACK && $key <= 5)
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
<div id="user-sidebar" class="g-col-4 g-col-md-1 d-none d-lg-block">
    <div id="list-example" class="list-group sticky-top" style="top:1rem;">
        <a id="acc-info" class="list-group-item list-group-item-action {{ Request()->segment(2) == 'edit-profile' ? 'active' : '' }}" href="{{ route('get_user_profile_edit_route') }}"><i class="fas fa-user mr-2"></i>Account Infomation</a>
        <a class="list-group-item list-group-item-action" href="{{ route('get_personal_trading_list_route')}}"><i class="fas fa-bullhorn mr-2"></i>Personal Trading</a>
        <a class="list-group-item list-group-item-action" href="{{ route('get_real_estate_list_route') }}"><i class="fas fa-city mr-2"></i>Real Estate</a>
        <a class="list-group-item list-group-item-action" href="{{ route('get_job_searching_list_route') }}"><i class="fas fa-search-dollar mr-2"></i>Job Searching</a>
        <a class="list-group-item list-group-item-action" href="{{ route('get_bullboard_list_route') }}"><i class="fas fa-chart-bar mr-2"></i>Bullboard</a>
        <a id="town-info" class="list-group-item list-group-item-action {{ Request()->segment(2) == 'town' ? 'active' : '' }}" href="{{ route('get_user_setting_town_index_route') }}"><i class="far fa-thumbs-up mr-2"></i>Town Page</a>
        <a id="business-info" class="list-group-item list-group-item-action {{ Request()->segment(2) == 'business' ? 'active' : '' }}" href="{{ route('get_user_setting_business_index_route') }}"><i class="fas fa-briefcase mr-2"></i>Business Page</a>
    </div>
</div>
