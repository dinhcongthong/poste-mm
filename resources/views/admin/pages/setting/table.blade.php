<table class="setting-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Value</th>
            <th>Tag</th>
            <th>User</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach ($settingList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->value }}</td>
            <td class="text-center">{{ $item->getTag->news_type }}</td>
            <td class="text-center">{{ getUserName($item->getUser) }}</td>
            <td class="text-center">{{ $item->updated_at }}</td>
            <td class="text-center">
                <a href="{{ route('post_setting_edit_ad_route', ['id' => $item->id]) }}" class="text-primary mx-1">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="text-danger mx-1 btn-delete" data-id="{{ $item->id }}">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody> --}}
</table>