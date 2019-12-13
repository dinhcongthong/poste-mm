
<table class="datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>User</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($districtList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->getCity->name }}</td>
            <td class="text-center">{{ getUserName($item->getUser) }}</td>
            <td class="text-center">
                <a href="#" class="change-status " data-id="{{ $item->id }}">
                    @if($item->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
