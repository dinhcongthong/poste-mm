<url>
    <loc>{{ route('get_lifetip_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$lifetipCategoryList->isEmpty())
    @foreach ($lifetipCategoryList as $item)
        <url>
            <loc>{{ route('get_lifetip_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$lifetips_list->isEmpty())
    @foreach ($lifetips_list as $item)
        <url>
            <loc>{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
