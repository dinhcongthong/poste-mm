<table class="datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Brand</th>
            <th>User</th>
            <th>Updated</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($theaterList as $item)
        @php 
        $positionList = $item->getChildTheaterWithTrashed;
        @endphp 
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td></td>
            <td class="text-center">{{ getUserName($item->getUser) }}</td>
            <td class="text-center">{{ $item->updated_at }}</td>
            <td class="text-center">
                <a href="#" class="btn-change-status" data-id="{{ $item->id }}">
                    @if($item->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>
            </td>
            <td class="text-center">
                <a href="{{ route('get_theater_edit_ad_route', ['id' => $item->id]) }}" class="mx-1" title="Edit">
                    <i class="fas fa-edit text-primary"></i>
                </a>
                @if($positionList->isEmpty())
                <a href="#" class="mx-1 btn-delete" title="Delete" data-id={{ $item->id }}>
                    <i class="fas fa-trash text-danger"></i>
                </a>
                @endif
            </td>
        </tr>
        @foreach($positionList as $position)
        <tr>
            <td class="text-center">{{ $position->id }}</td>
            <td>{{ $position->name }}</td>
            <td class="text-center">{{ $item->name }}</td>
            <td class="text-center">{{ getUserName($position->getUser) }}</td>
            <td class="text-center">{{ $position->updated_at }}</td>
            <td class="text-center">
                <a href="#" class="btn-change-status" data-id="{{ $position->id }}">
                    @if($position->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>
            </td>
            <td class="text-center">
                <a href="{{ route('get_theater_edit_ad_route', ['id' => $item->id]) }}" class="mx-1" title="Edit">
                    <i class="fas fa-edit text-primary"></i>
                </a>
                <a href="#" class="mx-1 btn-delete" title="Delete" data-id={{ $position->id }}>
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>