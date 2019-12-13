<url>
    <loc>{{ route('get_dailyinfo_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$dailyinfoCategoryList->isEmpty())
    @foreach ($dailyinfoCategoryList as $item)
        <url>
            <loc>{{ route('get_dailyinfo_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$dailyinfo_list->isEmpty())
    @foreach ($dailyinfo_list as $item)
        <url>
            <loc>{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
