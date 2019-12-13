<div class="swiper-wrapper">
    @foreach ($businessCategoryList as $item)
        <div class="swiper-slide py-2 bg-white border rounded border-light">
            <a class="w-100" href="{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}">
                <div class="text-center text-dark">
                    {{ $item->name }}
                </div>
            </a>
        </div>
    @endforeach
</div>
<div class="swiper-scrollbar d-lg-none"></div>
