@extends('admin.layouts.master')

@section('stylesheets')
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
@endsection

@section('content')
<div class="row no-gutters py-2">
    <a href="{{ route('get_ads_position_add_ad_route') }}" class="btn btn-primary ml-auto" role="button">Add New</a>
</div>
<div class="row no-gutters py-2">
    <div class="table-responsive" id="table-view">
        <table class="ads-position-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Position</th>
                    <th>Arrangement</th>
                    <th>Version Show</th>
                    <th>User</th>
                    <th>Updated_at</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            {{-- <tbody>
                @foreach ($positionList as $position)
                <tr>
                    <td>{{ $position->id }}</td>
                    <td>{{ $position->name }}</td>
                    <td>
                        <select class="form-control select2-no-search sl-how-to-show" data-id="{{ $position->id }}">
                            @foreach($howToShowList as $key => $item)
                            <option value="{{ $key }}" {{ $position->how_to_show == $key ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2-no-search sl-version-show" data-id="{{ $position->id }}">
                            @foreach($versionShowList as $key => $item)
                            <option value="{{ $key }}" {{ $position->version_show == $key ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ getUserName($position->getUser) }}</td>
                    <td class="text-center">{{ $position->updated_at }}</td>
                    <td class="text-center">
                        <a class="mx-1" href="{{ route('get_ads_position_edit_ad_route', ['id' => $position->id]) }}">
                            <i class="fas fa-edit text-primary"></i>
                        </a>
                    </td>
                </tr>                    
                @endforeach
            </tbody>
            --}}
        </table>
    </div>
</div>
@endsection