<url>
    <loc>{{ route('get_real_estate_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$real_category_list->isEmpty())
    @foreach ($real_category_list as $item)
        <url>
            <loc>{{ route('get_real_estate_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$real_type_list->isEmpty())
    @foreach ($real_type_list as $item)
        <url>
            <loc>{{ route('get_real_estate_type_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$real_price_list->isEmpty())
    @foreach ($real_price_list as $item)
        <url>
            <loc>{{ route('get_real_estate_price_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$real_bedroom_list->isEmpty())
    @foreach ($real_bedroom_list as $item)
        <url>
            <loc>{{ route('get_real_estate_bedroom_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$real_list->isEmpty())
    @foreach ($real_list as $item)
        <url>
            <loc>{{ route('get_real_estate_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
