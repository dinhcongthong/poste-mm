<table class="table table-hover town-datatables rounded-lg table-bordered border-top-0 border-left-0 border-right-0" style="margin: 2rem auto !important;">
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
        @foreach (Auth::user()->getTownPage as $item)
            <tr class="user-table-item">
                <td class="text-center">
                    {{ $item->id }}
                </td>
                <td class="col text-truncate align-middle">
                    <a href="{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}" target="_blank" class="d-block h5 m-0">
                        <i class="fas fa-eye mr-2"></i>
                        {{ $item->name }}
                    </a>
                    <small class="text-black-50">Expired on {{ $item->end_date }}</small>
                </td>
                <td class="text-center align-middle small">{{ $item->updated_at }}</td>

                <td class="text-center align-middle">
                    <a href="#" class="town-change-status" data-id="{{ $item->id }}">
                        @if (!$item->trashed())
                            <i class="fas fa-check-circle text-success h5 m-0" data-toggle="tooltip" title="Active"></i>
                        @else
                            <i class="far fa-trash-alt-circle text-danger h5 m-0" data-toggle="tooltip" title="Pending"></i>
                        @endif
                    </a>
                </td>

                <td class="col-auto text-center align-middle">
                    <a href="{{ route('get_town_edit_route', $item->slug.'-'.$item->id) }}" class="nav-link p-0"><i class="fas fa-edit m-0" title="Edit"></i></a>
                </td>
                <td class="col-auto text-center align-middle">
                    <a href="#" class="text-center align-middle nav-link text-danger btn-delete-town p-0" data-id="{{$item->id}}"><i class="far fa-trash-alt m-0"></i></a>
                </td>
            </tr>
        @endforeach

    </tbody> --}}
</table>
