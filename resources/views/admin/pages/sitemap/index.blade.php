<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ URL::to('/') }}</loc>

        <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

        <changefreq>daily</changefreq>

        <priority>1</priority>
    </url>
    <url>
        <loc>{{ URL::to('/login') }}</loc>

        <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

        <changefreq>never</changefreq>

        <priority>1</priority>
    </url>
    <url>
        <loc>{{ URL::to('/register') }}</loc>

        <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

        <changefreq>never</changefreq>

        <priority>1</priority>
    </url>
    <url>
        <loc>{{ URL::to('/contact') }}</loc>

        <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

        <changefreq>never</changefreq>

        <priority>1</priority>
    </url>
    <url>
        <loc>{{ URL::to('/term-of-use') }}</loc>

        <lastmod>{{ Carbon\Carbon::now()->toAtomString() }}</lastmod>

        <changefreq>never</changefreq>

        <priority>1</priority>
    </url>

    @include('admin.pages.sitemap.town')
    @include('admin.pages.sitemap.business')


    @include('admin.pages.sitemap.dailyinfo')
    @include('admin.pages.sitemap.lifetip')

    @include('admin.pages.sitemap.personal-trading')
    @include('admin.pages.sitemap.real-estate')
    @include('admin.pages.sitemap.job-searching')
    @include('admin.pages.sitemap.bullboard')


    @include('admin.pages.sitemap.golf')

    @if (!$golf_list->isEmpty())
        @foreach ($golf_list as $item)
            <url>
                <loc>{{ route('get_cinema_index_route', $item->slug.'-'.$item->id) }}</loc>

                <lastmod>{{ $item->updated_at->toAtomString() }}</lastmod>

                <changefreq>weekly</changefreq>

                <priority>0.7</priority>
            </url>
        @endforeach
    @endif
</urlset>
