<url>
    <loc>{{ route('get_business_index_route') }}</loc>

    <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

    <changefreq>daily</changefreq>

    <priority>0.7</priority>
</url>

@if (!$businessCategoryList->isEmpty())
    @foreach ($businessCategoryList as $item)
        <url>
            <loc>{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>
            
            <priority>0.7</priority>
        </url>
    @endforeach
@endif

@if (!$business_list->isEmpty())
    @foreach ($business_list as $item)
        <url>
            <loc>{{ route('get_business_detail_route', $item->slug.'-'.$item->id) }}</loc>

            <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

            <priority>0.8</priority>
        </url>
    @endforeach
@endif
