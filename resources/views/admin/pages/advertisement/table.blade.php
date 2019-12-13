<table class="ads-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>User</th>
            <th>Status</th>
            <th>Inform Sale</th>
            <th>Updated_at</th>
            <th>Action</th>
        </tr>
    </thead>
    {{--
    <tbody>
        <!-- foreach ($adList as $item) -->
        <tr>
            <td class="text-center">{{ $item->id }}</td>
            <td>
                {{ $item->name }}
                <a href="#" class="ml-2" data-toggle="tooltip" data-placement="bottom" title="{{ $item->end_date }}">
                    @if(date('Y-m-d') > date('Y-m-d', strtotime($item->end_date)))
                    <i class="far fa-calendar-alt text-daner"></i>
                    @else
                    <i class="far fa-calendar-alt text-success"></i>
                    @endif
                </a>
            </td>
            <td>{{ $item->getAdPosition->name }}</td>
            <td>{{ getUserName($item->getUser) }}</td>
            <td class="text-center">
                <a class="change-status" href="#" data-id="{{ $item->id }}">
                    @if($item->trashed())
                    <i class="fas fa-times-circle text-danger"></i>
                    @else
                    <i class="fas fa-check-circle text-success"></i>
                    @endif
                </a>
            </td>
            <td class="text-center">
                <button type="button" class="btn-inform btn btn-sm {{ $item->inform_sale ? 'btn-success' : 'btn-danger' }}" data-id="{{ $item->id }}">{{ $item->inform_sale ? 'Informing' : 'Expired'}}</button>
            </td>
            <td class="text-center">{{ $item->updated_at }}</td>
            <td class="text-center">
                <a class="mx-1 text-primary" href="{{ route('get_ads_edit_ad_route', ['id' => $item->id]) }}">
                    <i class="fas fa-edit"></i>
                </a>
                
            </td>
        </tr>
        <!-- endforeach -->
    </tbody>
    --}}

</table>