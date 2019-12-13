<url>
    <loc>{{ route('get_town_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$posteTownCategoryList->isEmpty())
    @foreach ($posteTownCategoryList as $item)
        <url>
            <loc>{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$tag_list->isEmpty())
    @foreach ($tag_list as $item)
        <url>
            <loc>{{ route('get_town_tag_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$town_list->isEmpty())
    @foreach ($town_list as $item)
        <url>
            <loc>{{ route('get_town_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <changefreq>daily</changefreq>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
