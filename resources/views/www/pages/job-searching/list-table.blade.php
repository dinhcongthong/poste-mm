<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center">#</th>
                <th>Name</th>
                <th class="text-center">Updated date</th>
                <th class="text-center">Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articleList as $item)       
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
                    <a href="{{ route('get_jobsearching_detail_route', $item->slug.'-'.$item->id) }}" class="mx-1 text-secondary" target="_blank">
                        <i class="fas fa-link"></i>
                    </a>
                    @endif
                    <a href="{{ route('get_job_searching_edit_route', $item->slug.'-'.$item->id) }}" class="mx-1">
                        <i class="fas fa-edit text-primary"></i>
                    </a>
                    <a href="#" class="mx-1 btn-delete" data-id="{{ $item->id }}" data-type="job-searching">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="paginate-area">
    {{ $articleList->links() }}
</div>