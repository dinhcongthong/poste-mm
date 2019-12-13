<div class="avartar text-center">
    @php
    $thumbnail = Auth::user()->getThumb;
    @endphp
    <img class="img-fluid mb-2" src="{{ empty($thumbnail) ? asset('images/poste/no-avatar.png') : App\Models\Base::getUploadURL($thumbnail->name, $thumbnail->dir) }}" alt="{{ 'Avatar of '.getUserName(Auth::user()).' さん' }}">
    <a class="btn-logout" href="#">ログアウト</a>
</div>
<div class="welcome">
    <b>こんにちわ！</b>
</div>
<div class="info h-100 p-3">
    <a class="btn btn-light" href="{{ route('get_user_setting_index_route') }}" title="Account setting">
        <b>{{ getUserName(Auth::user()).' さん' }}</b>
    </a>
</div>
<div class="dropdown col-12 col-md-2 align-items-center" style="padding-bottom: 10px; margin-top: -15px;">
    <button class="btn btn-light rounded-circle dropdown-toogle new-noti" type="button" id="notiButton" title="Notification" data-toggle="dropdown" noti-counter="{{ $notify_list->where('status', 0)->count() }}" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-bell" style="font-size:2rem; opacity:.8;"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right p-0 rounded-lg overflow-hidden shadow-lg" aria-labelledby="notiButton" style="z-index: 10000; left: 0 !important; right: auto;">
        <div class="dropdown-item bg-dark border-bottom text-white p-0 d-flex align-items-center">
            <h6 class="flex-grow-1 m-0 px-3 py-2">NOTIFICATIONS</h6>
            <a class="text-right text-light small flex-shrink-1 m-0 px-3 py-2" href="#" id="read-all">Mark all as read</a>
        </div>

        <div class="dropdown-item p-0 list-group list-group-flush noti-list">
            @forelse ($notify_list as $key => $item)
            @if($item->type_id == App\Models\PosteNotification::TYPE_FEEDBACK && $key <= 9)
            <a class="list-group-item list-group-item-action noti {{ $item->status == 1 ? "noti-seen" : '' }}" href="{{ route('get_detail_notification_route', $item->id) }}">
                <strong>{{ $item->name }}</strong> has left a feedback on your "<span class="font-weight-bold">{{ !is_null($item->getType()['type']) ? $item->getType()['type']->name : 'Deleted by Owner' }}</span>" page.
                <br>
                <small style="color:#a9a9a9;">Sent at {{ $item->created_at }}</small>
            </a>
            @endif
            @empty
            <p class="noti-no">No Unread Message</p>
            @endforelse
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center text-primary" href="{{ route('get_notification_route') }}"><em> See all </em></a>
    </div>
</div>

@include('auth.logout-form')
