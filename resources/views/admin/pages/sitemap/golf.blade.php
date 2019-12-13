<url>
    <loc>{{ route('get_golf_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$golf_list->isEmpty())
    @foreach ($golf_list as $item)
        <url>
            <loc>{{ route('get_golf_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif


@if (!$golf_shop_list->isEmpty())
    @foreach ($golf_shop_list as $item)
        <url>
            <loc>{{ route('get_golf_shop_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
