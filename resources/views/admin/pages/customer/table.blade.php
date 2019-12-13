@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <a href="{{ route('get_customer_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
</div>
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        <table class="customer-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- <tbody>
    
                @foreach ($customerList as $item)
                <tr>
                    <td class="text-center">{{ $item->id }}</td>
                    <td class="text-center">
                        <a class="text-dark" href="#id-{{ $item->id }}" data-toggle="collapse">
                            {{ $item->name }}
                            <i class="fas fa-caret-down text-success"></i>
                        </a>
                        <div class="collapse w-100 bg-white mt-2 p-2" id="id-{{ $item->id }}">
                            <b>Owner Name: </b> {{ $item->owner_name }}<br/>
                            <b>Phone: </b> {{ $item->phone }}<br/>
                            <b>Email: </b> {{ $item->email }}<br/>
                        </div>
                    </td>
                    <td class="text-center">{{ getUserName($item->getUser) }}</td>
                    <td class="text-center">
                        <a  href="#" class="change-status" data-id="{{ $item->id }}">
                        @if($item->trashed())
                        <i class="fas fa-times-circle text-danger"></i>
                        @else
                        <i class="fas fa-check-circle text-success"></i>
                        @endif
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('get_customer_edit_ad_route', ['id' => $item->id]) }}" class="edit-customer">
                            <i class="fas fa-edit text-primary"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
</div>
@endsection