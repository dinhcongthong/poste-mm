<table class="daily-info-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User</th>
            <th>Updated</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    {{--
    <tbody>
        @foreach ($dailyinfoList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>
                {{ $item->name }}
                <a href="{{ route('get_dailyinfo_preview_ad_route', $item->slug.'-'.$item->id) }}" class="mx-1" target="_blank">
                    <i class="fas fa-eye text-primary"></i>
                </a>
            </td>
            <td class="text-center">{{ getUserName($item->getUser) }}</td>
            <td class="text-center">{{ $item->updated_at }}</td>
            <td class="text-center">
                <a href="#" class="change-status" data-id="{{ $item->id }}">
                    @if($item->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>
            </td>
            <td class="text-center">
                <a class="mx-1" href="{{ route('get_dailyinfo_edit_ad_route', ['id' => $item->id]) }}">
                    <i class="fas fa-edit text-primary"></i>
                </a>
                <a class="mx-1 btn-delete" href="#" data-id="{{ $item->id }}">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    --}}
</table>