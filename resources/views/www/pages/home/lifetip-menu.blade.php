@foreach ($lifetipCategoryList as $item)    
<a href="{{ route('get_lifetip_category_route', $item->slug.'-'.$item->id) }}" class="lifenav-item btn btn-light">
<img src="{{ App\Models\Base::getUploadURL($item->getIcon->name, $item->getIcon->dir) }}" class="img-fluid" alt="{{ 'lifetip,category,'.$item->name }}">
    {{ $item->name }}
</a>
@endforeach