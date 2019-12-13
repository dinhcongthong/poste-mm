@extends('user-setting.layouts.masterGlobal')
@section('content')
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
    td {
        text-align: center;
    }
    .noti > a{
        color: #000;
    }
    .noti.noti-seen > a{
        color: var(--secondary);
    }
    .noti:hover > a{
        color: var(--dark);
    }
    .noti.noti-seen:hover > a{
        color: var(--secondary);
    }
    .text-seen{
        color: #999;
    }
    .text-seen:hover > i{
        font-weight: 400 !important;
    }
    .noti-seen .text-seen:hover > i{
        font-weight: 900 !important;
        color: #888;
    }
    .noti:hover > .flex-shrink-1{
        visibility: visible !important;
    }
    
    #unread + label + .noti-list .noti.noti-seen{
        display: flex !important;
    }
    #unread:checked + label + .noti-list .noti.noti-seen{
        display: none !important;
    }
    #unread + label{
        display: flex;
        align-items: center;
        color: #999;
        font-style: italic;
    }
    #unread + label::before{
        position: relative;
        display: inline-block;
        margin-right: .5rem;
        top: initial;
        left: initial;
        width: 1.25rem;
        height: 1.25rem;
    }
    #unread + label::after{
        position: absolute;
        display: inline-block;
        top: initial;
        left: initial;
        width: 1.25rem;
        height: 1.25rem;
    }
    
    [noti-counter="0"]::after{
        visibility: hidden;
    }
</style>
<div id="user-summary" class="g-col-4 g-col-md-3">
    <div class="row">
        <div class="col-12">
            <h4>
                Your Notifications
            </h4>
            <div class="dropdown-divider mb-5"></div>
        </div>
        
        <div class="col-12 px-3 custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="unread">
            <label class="custom-control-label mb-3" for="unread">Show unread notifications only</label>
            
            <ul class="list-group list-group-flush noti-list overflow-hidden" style="border-radius: .5rem;">
                @forelse ($notify_paginate as $key => $item)
                @if($item->type_id == App\Models\PosteNotification::TYPE_FEEDBACK)
                <li class="list-group-item list-group-item-action d-flex align-items-center overflow-hidden noti {{ $item->status == 1 ? "noti-seen" : '' }}" id="noti-li" data-id="{{ $item->id }}">
                    <a class="flex-grow-1 rounded-lg" href="{{ route('get_detail_notification_route', $item->id) }}">
                        @if(!is_null($item->getType()['type']))
                        <span class="font-weight-bold">{{ $item->name }}</span> has left a feedback on your "<span class="font-weight-bold">{{ $item->getType()['type']->name }}</span>" page.
                        @else
                        <span class="font-weight-bold">Deleted by Owner</span>
                        @endif
                        <br>
                        <small style="color:#a9a9a9;">Sent at {{ $item->created_at }}</small>
                    </a>
                    <div class="d-flex flex-column flex-shrink-1 visible invisible-lg">
                        <a href="#" class="btn text-secondary px-3 py-0 noti-delete" data-toggle="tooltip" title="Remove this notification" data-id="{{ $item->id }}">
                            <i class="far fa-trash-alt"></i>
                        </a>
                        <a href="#" class="btn text-seen px-3 py-0 check-seen" data-toggle="tooltip" data-placement="bottom" title="{{ $item->status == 1 ? 'Mark as unread' : 'Mark as read' }}" data-id="{{ $item->id }}">
                            <i class="{{ $item->status == 1 ? 'far fa-circle' : 'fas fa-circle text-success' }} small"></i>
                        </a>
                    </div>
                </li>
                @endif
                @empty
                <p class="noti-no">No Unread Message</p>
                @endforelse
            </ul>
            <div id="premium-pagination" style="padding-top: 20px;">
                <nav aria-label="Page navigation example">
                    {{ $notify_paginate->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#notifications').DataTable({
            "order": [[8, 'desc']]
        }).on('draw', function () {
            
        });
    });
</script>
@endsection
