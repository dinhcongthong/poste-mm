<table class="datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Release Date</th>
            <th>User</th>
            <th>Updated</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movieList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td class="text-center">{{ date('m-d-Y', strtotime($item->published_at)) }}</td>
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
                <a href="{{ route('get_movie_edit_ad_route', ['id' => $item->id]) }}" class="mx-1" title="Edit">
                    <i class="fas fa-edit text-primary"></i>
                </a>
                <a href="#" class="mx-1 btn-delete" title="Delete" data-id="{{ $item->id }}">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>