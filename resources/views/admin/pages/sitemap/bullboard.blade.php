<url>
    <loc>{{ route('get_bullboard_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$bullboard_category_list->isEmpty())
    @foreach ($bullboard_category_list as $item)
        <url>
            <loc>{{ route('get_bullboard_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$bullboard_list->isEmpty())
    @foreach ($bullboard_list as $item)
        <url>
            <loc>{{ route('get_bullboard_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
