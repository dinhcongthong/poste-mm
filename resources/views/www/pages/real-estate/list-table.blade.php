<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Updated date</th>
                <th class="text-center">Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articleList as $item)    
            <tr class="article">
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ date('Y-m-d', strtotime($item->updated_at)) }}</td>
                <td class="text-center">
                    @if($item->trashed())
                    <span class="badge badge-danger">Confirming</span>
                    @else
                    <span class="badge badge-success">Approved</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(!$item->trashed())
                    <a href="{{ route('get_real_estate_detail_route', $item->slug.'-'.$item->id) }}" class="mx-1 text-secondary" target="_blank">
                        <i class="fas fa-link"></i>
                    </a>
                    @endif
                    <a href="{{ route('get_real_estate_edit_route', $item->slug.'-'.$item->id) }}" class="mx-1">
                        <i class="fas fa-edit text-primary"></i>
                    </a>
                    <a href="#" class="mx-1 btn-delete" data-type="real-estate" data-id="{{ $item->id }}">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">NO ARTICLE</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="paginate-area">
    {{ $articleList->links() }}
</div>