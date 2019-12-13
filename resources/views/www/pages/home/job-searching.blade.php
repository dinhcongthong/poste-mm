<div class="wrapper bg-grey p-0">
    <div class="section-header">
        <span class="d-inline-block text-truncate">お仕事探し</span>
        <a href="{{ route('get_jobsearching_index_route') }}" class="btn"><span class="d-none d-lg-inline-block text-truncate">一覧リスト</span></a>
    </div>
    <div class="d-grid xr3 g-3 p-3">
        @forelse ($jobSearchingList as $item)
        <div class="classify-item">
            <a href="{{ route('get_jobsearching_detail_route', $item->slug.'-'.$item->id) }}">
                <div>
                    <ul class="label-list p-0 mb-2">
                        <li class="label-item">{{ $item->type->name }}</li>
                        <li class="label-item">{{ $item->category->name }}</li>
                    </ul>
                    <h2 href="#" class="nav-link px-3 py-0 mb-2">{{ $item->name }}</h2>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="small p-2">{{ date('Y-m-d', strtotime($item->updated_at)) }}</span>
                    <span class="small text-truncate p-2">{{ $item->salary }}</span>
                </div>
            </a>
        </div>
        @empty
        <img class="img-fluid g-row-3" src="{{ asset('images/poste/classifieds.png') }}" alt="Job Searching" style="filter: grayscale(1);">
        @endforelse
    </div>
    <div class="section-footer text-truncate bg-light rounded-bottom py-2 px-3">
        <a href="{{ route('get_job_searching_add_route') }}" class="btn btn-sm btn-outline-secondary float-right ml-2"><i class="material-icons" style="font-size: 12px;">create</i> 新規投稿</a>
        <a href="{{ route('get_job_searching_list_route') }}" class="btn btn-sm btn-outline-secondary float-right ml-2">削除・変更</a>
    </div>
</div>