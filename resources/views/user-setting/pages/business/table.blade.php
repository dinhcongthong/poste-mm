<table class="table table-hover business-datatables rounded-lg table-bordered border-top-0 border-left-0 border-right-0" style="margin: 2rem auto !important;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Expired date</th>
            <th>Last updated</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach (Auth::user()->getBusinessPage as $item)
            <tr class="user-table-item">
                <td class="text-center">
                    {{ $item->id }}
                </td>
                <td class="col text-truncate align-middle">
                    <a href="{{ route('get_business_detail_route', $item->slug.'-'.$item->id) }}" target="_blank">
                        <i class="fas fa-eye mr-2"></i>
                        {{ $item->name }}
                    </a>
                </td>
                <td class="text-center align-middle">{{ $item->end_date }}</td>
                <td class="text-center align-middle">{{ $item->updated_at }}</td>
                @if ($item->trashed())
                    <td class="text-center align-middle"><a href="#" class="business-change-status" data-id="{{ $item->id }}"><i class="fas fa-check-circle text-success"></i></a></td>
                @else
                    <td class="text-center align-middle"><a href="#" class="business-change-status" data-id="{{ $item->id }}"><i class="far fa-trash-alt-circle text-danger"></i></a></td>
                @endif
                <td class="col-auto">
                    <a href="{{ route('get_business_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link"><i class="fas fa-edit mr-2" title="Edit"></i></a>
                </td>
                <td class="col-auto">
                    <a href="#" class="text-center align-middle nav-link text-danger btn-delete-business" data-id="{{ $item->id }}"><i class="far fa-trash-alt mr-2"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody> --}}
</table>
