<url>
    <loc>{{ route('get_jobsearching_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$job_category_list->isEmpty())
    @foreach ($job_category_list as $item)
        <url>
            <loc>{{ route('get_jobsearching_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$job_type_list->isEmpty())
    @foreach ($job_type_list as $item)
        <url>
            <loc>{{ route('get_jobsearching_type_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$job_employee_list->isEmpty())
    @foreach ($job_employee_list as $item)
        <url>
            <loc>{{ route('get_jobsearching_nationality_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$job_list->isEmpty())
    @foreach ($job_list as $item)
        <url>
            <loc>{{ route('get_jobsearching_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
