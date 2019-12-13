<ul class="nav nav-pills swiper-wrapper">
    @foreach ($lifetipCategoryList as $item)
    
    <li class="nav-item swiper-slide">
        <a class="nav-link" href="{{ route('get_lifetip_category_route', $item->slug.'-'.$item->id) }}">
            <img src="{{ App\Models\Base::getUploadURL($item->getIcon->name, $item->getIcon->dir) }}" alt="{{ $item->name.','.$item->slug }}">
            {{ $item->name }}
        </a>
    </li>
    
    @endforeach
</ul>