 <ul class="nav nav-pills swiper-wrapper" role="tablist">
    @foreach ($dailyinfoCategoryList as $item)    
    <li class="nav-item swiper-slide">
        <a class="nav-link" href="{{ route('get_dailyinfo_category_route', $item->slug.'-'.$item->id) }}">
            <img src="{{ App\Models\Base::getUploadURL($item->getIcon->name, $item->getIcon->dir) }}" alt="{{ $item->slug.','.$item->name}}">
            {{ $item->name }}
        </a>
    </li>
    @endforeach
</ul>