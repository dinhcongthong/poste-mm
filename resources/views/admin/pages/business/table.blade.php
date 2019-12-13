<table id="business-list" class="business-datatables table table-stripped table-bordered" style="font-size: 0.9rem;">
    <thead class="thead-dark text-center">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User</th>
            <th>Owner</th>
            <th>Info</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    {{-- 
    <tbody>
        @foreach ($article_list as $item)
            @php
            if($item->fee == SALE_INFORMING && $item->end_date >= date('Y-m-d')) {
                $type = 'premium';
            } else {
                if($item->end_free_date >= date('Y-m-d')) {
                    $type = 'free_premium';
                } else {
                    $type = 'free';
                }
            }
            @endphp
            <tr>
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ getUserName($item->getUser) }}</td>
                <td class="text-center">
                    {!! getUserName($item->getOwner)."<br/>" !!}
                    <a class="change-owner" href="#user-list-modal" data-toggle="modal" data-id="{{ $item->id }}">Change Owner</a>
                </td>
                <td>
                    Updated by: <strong>{{ getUserName($item->getUser) }}</strong><br/>
                    Created at: <strong>{{ $item->created_at }}</strong><br/>
                    Last updated at: <strong> {{ $item->updated_at }}</strong><br/>
                    Type:
                    @if($type == 'premium')
                        <label class="badge badge-primary">Premium Page</label>
                    @elseif($type == 'free_premium')
                        <label class="badge badge-success">Free - In Premium</label>
                    @else
                        <label class="badge badge-danger">Free Page</label>
                    @endif
                    <br/>
                    <a href="{{ route('get_business_edit_info', $item->id) }}">Edit Info</a>
                </td>
                <td class="text-center">
                    @if(!is_null($item->getUser))
                        @if($item->trashed())
                            @if($item->getUser->type_id != App\Models\User::TYPE_ADMIN)
                                <button type="button" class="btn btn-danger btn-status" data-type="restore" data-id="{{ $item->id }}">Deleted By User</button>
                            @else
                                <button type="button" class="btn btn-danger btn-status" data-id="{{ $item->id }}">Pending</button>
                            @endif
                        @else
                            <button type="button" class="btn btn-success btn-status" data-id="{{ $item->id }}">Normal</button>
                        @endif
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('get_business_edit_route', $item->slug.'-'.$item->id) }}" target="_blank" class="mx-1 text-primary">
                        <i class="fas fa-edit text-primary"></i>
                    </a>
                    @if($item->owner_id == 0 || $item->owner_id == Auth::user()->id)
                        <a class="mx-1 btn-delete" href="#" data-id="{{ $item->id }}">
                            <i class="fas fa-trash text-danger"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    --}}
</table>
