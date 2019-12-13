@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        @include('admin.pages.business.table')
    </div>
</div>

{{-- User List Modal --}}
<div class="modal fade" id="user-list-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog centered-vertically modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Set Owner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="user-list" class="table datatables table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_list as $item)
                            <tr>
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ getUserName($item) }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning text-white set-owner" data-owner="{{ $item->id }}">SET</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
