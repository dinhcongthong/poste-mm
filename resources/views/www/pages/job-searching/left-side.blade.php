<div class="d-grid x1 x2-md x1-lg g-2">
    <a href="{{ route('get_job_searching_add_route') }}" class="btn btn-primary w-100" title="新規投稿"><i class="fas fa-pencil-alt"></i> 新規投稿</a>
    <a href="{{ route('get_job_searching_list_route') }}" class="btn btn-outline-secondary w-100" title="削除・変更">削除・変更</a>
</div>
<div class="seperate"></div>
<div class="d-lg-none">
    <a href="#filter" data-toggle="collapse" class="btn btn-outline-secondary btn-block" title="filter">Filter</a>
</div>
<div class="collapse d-lg-none mt-3" id="filter">
    <div class="type-option">
        <h3>雇用形態</h3>
        <ul>
            @foreach ($job_searching_type_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_type_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>職種</h3>
        <ul>
            @foreach ($job_searching_category_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_category_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>雇用人種</h3>
        <ul>
           @foreach ($job_searching_employee_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_nationality_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="d-none d-lg-block">
    <div class="type-option">
        <h3>雇用形態</h3>
        <ul>
            @foreach ($job_searching_type_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_type_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>職種</h3>
        <ul>
           @foreach ($job_searching_category_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_category_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="seperate"></div>
    <div class="type-option">
        <h3>雇用人種</h3>
        <ul>
           @foreach ($job_searching_employee_list as $item)    
            <li>
                <a href="{{ route('get_jobsearching_nationality_route', $item->slug.'-'.$item->id) }}">
                    <i class="fas fa-chevron-right"></i> {{ $item->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>