 <div class="swiper-wrapper">
     @foreach ($posteTownCategoryList as $item)
     <div class="swiper-slide py-2">
         <a href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}">
            <div class="text-center">
                 <img class="m-auto" src="{{ App\Models\Base::getUploadURL($item->getIcon->name, $item->getIcon->dir) }}" alt="{{ $item->slug.','.$item->name}}" width="25"><br/>
                 {{ $item->name }}
            </div>
         </a>
    </div>
    @endforeach
</div>
<div class="swiper-scrollbar d-lg-none"></div>
