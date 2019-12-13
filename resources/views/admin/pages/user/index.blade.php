@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        <table class="user-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Is Letter</th>
                    <th>Permission</th>
                    <th>Updated_at</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($userList as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <a class="text-dark" href="#id-{{ $item->id }}" data-toggle="collapse">
                            {{ getUserName($item) }}
                            <i class="fas fa-caret-down text-success"></i>
                        </a>
                        <div class="collapse w-100 bg-white mt-2 p-2" id="id-{{ $item->id }}">
                            <b>Email: </b> {{ $item->email }}<br/>
                            <b>Phone: </b> {{ $item->phone }}<br/>
                            <b>Gender: </b> {{ $item->gender_id ? '女性' : '男性' }}<br/>
                            <b>DOB: </b> {{ $item->birthday }}<br/>
                            <b>Created_at: </b> {{ $item->created_at }}
                        </div>
                    </td>
                    <td>
                        <select class="form-control sl-change-letter" data-id="{{ $item->id }}">
                            <option value="1" {{ $item->is_news_letter ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$item->is_news_letter ? 'selected' : '' }}>No</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control sl-change-role" data-id="{{ $item->id }}">
                            <option value="1" {{ $item->type_id == 1 ? 'selected' : '' }}>Adminstrator</option>
                            <option value="2" {{ $item->type_id == 2 ? 'selected' : '' }}>Editor</option>
                            <option value="3" {{ $item->type_id == 3 ? 'selected' : '' }}>User</option>
                        </select>
                    </td>
                    <td class="text-center">{{ $item->updated_at }}</td>
                    <td class="text-center">
                        <a class="btn-change-status" href="#" data-id="{{ $item->id }}">
                            @if($item->trashed())
                            <i class="fas fa-times-circle text-danger"></i>
                            @else
                            <i class="fas fa-check-circle text-success"></i>
                            @endif
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn-delete" role="button" href="#">
                            <i class="fas fa-trash-alt text-danger"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
</div>    
@endsection