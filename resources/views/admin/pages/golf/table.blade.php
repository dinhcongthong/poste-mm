<input type="hidden" id="golf-type" value="{{ $type }}">
<table class="golf-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User</th>
            <th>Updated_at</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach ($golfList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>
                {{ $item->name }}
                @if($item->is_draft) 
                <span class="font-italic text-danger"> (Draft) </span>
                @endif
            </td>
            <td class="text-center">{{ getUserName($item->getUser) }}</td>
            <td class="text-center">{{ $item->updated_at }}</td>
            <td class="text-center">
                @unless ($item->is_draft)    
                <a class="btn-status" href="#" data-id="{{ $item->id }}">
                    @if(!$item->trashed()) 
                    <i class="fas fa-check-circle text-success"></i>
                    @else 
                    <i class="fas fa-times-circle text-danger"></i>
                    @endif    
                </a>
                @endunless
            </td>
            <td class="text-center">
                <a class="mx-1 text-primary" href="{{ $type == 'golf-shop' ? route('get_golf_shop_edit_ad_route', ['id' => $item->id]) : route('get_golf_edit_ad_route', ['id' => $item->id]) }}">
                    <i class="fas fa-edit"></i>
                </a> 
                <a class="mx-1 btn-delete" href="#" data-type="{{ $type }}" data-id="{{ $item->id }}">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody> --}}
</table>