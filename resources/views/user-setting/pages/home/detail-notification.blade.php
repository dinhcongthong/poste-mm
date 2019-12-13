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
    
    #noti-container{
        /* grid-template-rows: auto 1fr auto; */
    }
    #noti-from, #noti-to{
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        background: #fff;
        border-radius: .35rem;
        overflow: hidden;
        white-space: nowrap;
    }
    #noti-content{
        align-items: flex-start;
        background: #fff;
        border-radius: .35rem;
        overflow: hidden;
    }
    #noti-from::before, #noti-to::before{
        content: 'From';
        flex-shrink: 1;
        padding: .5rem 1rem;
        margin-right: 1rem;
        background: #eee;
    }
    #noti-to::before{
        content: 'To';
    }
    #noti-content::before{
        content: 'Message at ' attr(data-time);
        display: block;
        flex-shrink: 0;
        width: 100%;
        font-size: 80%;
        text-align: right;
        background: #f3f3f3;
        padding: .5rem 1rem;
        font-style: italic;
    }
</style>
<div id="user-summary" class="g-col-4 g-col-md-3">
    <div class="row h-100 flex-column">
        <div class="flex-shrink-1 px-3">
            <h4>
                Notification Detail
            </h4>
            <div class="dropdown-divider mb-5"></div>
        </div>
        
        <div class="flex-grow-1 px-3">
            <div id="noti-container" class="d-flex flex-column h-100 p-3 rounded-lg bg-light">
                <div class="flex-shrink-1 d-grid x12 g-3 mb-3">
                    <div id="noti-from" class="g-col-12 g-col-md-6 text-black-50 shadow-none hover">{{ $notify->name }} さん <a href="mailto:{{ $notify->email }}" class="flex-shrink-1 ml-auto px-3" data-toggle="tooltip" title="Reply {{ $notify->email }}"><i class="far fa-paper-plane"></i></a></div>
                    <div id="noti-to" class="g-col-12 g-col-md-6 text-black-50 shadow-none hover">
                        【<span class="text-truncate">{{ !is_null($notify->getType()['type']) ? $notify->getType()['type']->name : 'Deleted by Owner' }}</span>】 Page
                        @if(!is_null($notify->getType()['type']))
                        <a  href="{{ route($notify->getType()['route'], $notify->getType()['type']->slug.'-'.$notify->getType()['type']->id) }}" class="flex-shrink-1 ml-auto px-3" data-toggle="tooltip" title="View page" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                        @endif
                    </div>
                </div>
                <div id="noti-content" class="flex-grow-1 text-black-50 shadow-none hover" data-time="{{ $notify->created_at }}"><p class="p-3 m-0 h4 font-weight-normal">{{ $notify->content }}</p></div>
                @if(!is_null($notify->getType()['type']))
                <div id="noti-buttons" class="flex-shrink-1 p-3 text-center">
                    <a href="{{ route($notify->getType()['edit_route'], $notify->getType()['type']->slug.'-'.$notify->getType()['type']->id) }}" class="btn btn-primary rounded-pill"><i class="far fa-edit mr-2"></i>Improve your page</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
