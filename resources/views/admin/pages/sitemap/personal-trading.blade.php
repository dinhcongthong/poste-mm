<url>
    <loc>{{ route('get_personal_trading_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$personal_category_list->isEmpty())
    @foreach ($personal_category_list as $item)
        <url>
            <loc>{{ route('get_personal_trading_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif


@if (!$personal_type_list->isEmpty())
    @foreach ($personal_type_list as $item)
        <url>
            <loc>{{ route('get_personal_trading_type_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$personal_list->isEmpty())
    @foreach ($personal_list as $item)
        <url>
            <loc>{{ route('get_personal_trading_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
