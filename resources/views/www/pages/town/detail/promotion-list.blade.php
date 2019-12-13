<div id="promo-slider" class="p-3 p-lg-4">
    <div class="swiper-container">
        <div class="swiper-wrapper col-xs-12">
            @foreach($promotion_list as $promotion)
                <div class="swiper-slide">
                    <a href="{{ route('get_dailyinfo_detail_route', $promotion->slug.'-'.$promotion->id) }}" target="_blank">
                        <div class="media-wrapper-4x3 bg-warning rounded pst-relative d-flex flex-wrap" style="height: 220px; align-items: center;" >
                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($promotion->getThumbnail->name, $promotion->getThumbnail->dir) }}" alt="{{ $promotion->name }}" >
                            <div class="d-flex" style="align-items: flex-end;">
                                <h5 class="jyouhou_title">{{ $promotion->name }}</h5>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="pagination justify-content-center"></div>
</div>
