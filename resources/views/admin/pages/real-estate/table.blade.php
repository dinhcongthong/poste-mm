<table class="rees-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Athor</th>
            <th>Date added</th>
            <th>Published/Pending</th>
        </tr>
    </thead>
    {{-- <tbody>
        @foreach ($realEstateList as $item)
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td class="text-center">
                {{ getUserName($item->getUser) }}
            </td>
            <td class="text-center">
                {{ $item->created_at }}
            </td>
            <td class="text-center">
                <a href="#" class="change-status" data-id="{{ $item->id }}">
                    @if($item->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>   
                <a class="mx-1 btn-delete" href="#" data-id="{{ $item->id }}">
                    <i class="fas fa-trash text-danger"></i>
                </a> 
            </td>
        </tr>                    
        @endforeach
    </tbody> --}}
</table>

