<div id="relate-list" class="p-2 bg-light w-100">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($business_item->getBusinessRelateList as $item)
                <div class="swiper-slide">
                    <div class="bg-white p-3">
                        <h4>{{ $item->name }}</h4>
                        @if(!empty($item->address))
                            <p>
                                <i class="fas fa-map-marked-alt mr-3"></i> {{ $item->address }}
                            </p>
                        @endif
                        @if(!empty($item->phone))
                            <p>
                                <i class="fas fa-phone mr-3"></i> {{ $item->phone }}
                            </p>
                        @endif
                        @if(!empty($item->email))
                            <p>
                                <i class="far fa-envelope mr-3"></i> <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                            </p>
                        @endif
                        @if(!empty($item->website))
                            <p>
                                <i class="fas fa-home mr-3"></i> <a href="{{ $item->website }}" target="_blank">{{ $item->website }}</a>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
