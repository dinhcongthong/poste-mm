@foreach ($newsRankingList as $item)
<a href="{{ route('get_dailyinfo_detail_route', $item->slug.'-'.$item->id) }}" class="rank-item nav-link bg-light text-dark  shadow-sm">
    <div class="col-3 p-0 bg-light border">
        <img src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="{{ $item->name }}" class="img-cover">
    </div>
    <div class="col-9 pr-0 align-self-center">                        
        {{ $item->name }}
    </div>
</a>
@endforeach