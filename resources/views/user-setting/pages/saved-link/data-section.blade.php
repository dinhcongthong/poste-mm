
<div class="saved-item saved-{{ $item->post_type }} ">
    @if($item->post_type == 'town')
        <a target="_blank" href="{{ route('get_town_detail_route', $item->getPosteTown->slug.'-'.$item->post_id) }}" class="saved-item-name">
            {{ $item->getPosteTown->name }}
        </a>
    @else
        <a target="_blank" href="{{ route('get_business_detail_route', $item->getBusiness->slug.'-'.$item->post_id) }}" class="saved-item-name">
            {{ $item->getBusiness->name }}
        </a>
    @endif

    <button type="button" class="btn btn-link text-dark unsave" style="float: inline-end;" data-id="{{ $item->id }}"><i class="far fa-trash-alt"></i></button>

    <!-- <div class="saved-item-time">{ date('Y-m-d H:i:s', strtotime($recent_item->updated_at))  }}</div> -->
     <div class="saved-item-time" id="calc_time" data-time="{{ date('Y-m-d H:i:s', strtotime($item->updated_at))  }}" >{{ App\Models\SavedLink::timeAgo( date('Y-m-d H:i:s', strtotime($item->updated_at)) ) }}</div> 
</div>


