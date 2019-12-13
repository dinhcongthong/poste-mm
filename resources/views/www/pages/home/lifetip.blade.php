@foreach ($lifetipList as $item)    
<a href="{{ route('get_lifetip_detail_route', $item->slug.'-'.$item->id) }}" class="life-item text-dark {{ $item->datecount < 4 ? 'new' : '' }}">
    <div class=" col-12 media-wrapper h-100">
        <div class="d-flex">
            <div class="col-4 p-0">
                <img src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" class="img-cover" alt="{{ $item->name }}">
            </div>
            <div class="col-8 p-0">
                <div class="caption p-2">
                    <h2>{{ $item->name }}</h2>
                </div>
            </div>
        </div>
        <div class="life-label-{{ $item->getCategoryNews->first()->category_id }}"></div>
    </div>                    
</a>
@endforeach
<a href="{{ route('get_lifetip_index_route') }}" class="top-side-M view-all" title="もっと見る">
    <p class="view-all-ico d-none d-lg-inline-block">もっと見る </p>
    <i class="fa fa-list view-all-ico" aria-hidden="true"></i>
</a>

<div class="g-col-2 d-block d-lg-none">    
    @foreach ($ad_home_mobile_center_list as $item)
    @if($loop->index == 1)    
    <a class="top-side-M" href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
        <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
    </a>
    @break;
    @endif
    @endforeach
</div>