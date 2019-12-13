@foreach ($newsList as $item)    
<a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}" class="news-item text-light {{ $item->datecount < 4 ? 'new' : '' }}">
    <img src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" class="img-cover" alt="{{ $item->name }}">
    <div class="caption p-2 p-lg-3">
        <h2>{{ $item->name }}</h2>
        <span class="label-date">{{ date('Y/m/d', strtotime($item->published_at)) }}</span>
    </div>
</a>
@endforeach

<a href="{{ route('get_dailyinfo_index_route') }}" class="top-side-M view-all" title="過去のニュース一覧"><i class="fa fa-list view-all-ico" aria-hidden="true"></i></a>

<div class="g-col-2 d-block d-lg-none">    
    @foreach ($ad_home_mobile_center_list as $item)
    @if($loop->index == 0)    
    <a class="top-side-M" href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
        <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
    </a>
    @break;
    @endif
    @endforeach
</div>