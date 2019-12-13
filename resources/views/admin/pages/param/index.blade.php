@extends('admin.layouts.master')

@section('content')
<div class="row no-gutters py-2">
    <a href="{{ route('get_param_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
</div>
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        <table class="param-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Show on Gallery</th>
                    <th>User</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($paramList as $item)
                <tr>
                    <td class="text-center">{{ $item->id }}</td>
                    <td>{{ $item->news_type.'.'.$item->tag_type }}</td>
                    <td class="text-center">
                        <a href="#" class="change-show-gallery" data-id="{{ $item->id }}">
                            @if(!$item->show_on_gallery)
                            <i class="fas fa-times-circle text-danger"></i>
                            @else
                            <i class="fas fa-check-circle text-success"></i>
                            @endif
                        </a>    
                    </td>
                    <td class="text-center">
                        {{ getUserName($item->getUser) }}
                    </td>
                    <td class="text-center">
                        {{ $item->updated_at }}
                    </td>
                    
                </tr>                    
                @endforeach
            </tbody> --}}
        </table>
    </div>
</div>
@endsection