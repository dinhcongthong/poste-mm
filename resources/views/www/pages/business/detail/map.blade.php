<div class="row">
    <div class="col-12 col-lg-6">
        <iframe id="map-iframe" class="{{ $business_item->map ? '' : 'd-none' }}" src="{{ $business_item->map ?? '' }}" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        <img id="no-map-image" src="{{ asset('images/poste/no-map.jpg') }}" alt="{{ $business_item->name }}" class="img-fluid {{ $business_item->map ? 'd-none' : ''  }}">
    </div>
    <div class="col-12 col-lg-6">
        @if ($business_item->getMapList->isEmpty())
            <div class="row no-gutters">
                <div class="col-12 business-detail-map-item active px-3 px-lg-4 py-2">
                    <h4 class="address">{{ $business_item->address }}</h4>
                    @if (!empty($business_item->route_guide))
                        <p class="route-guide">
                            {{ nl2br($business_item->route_guide) }}
                        </p>
                    @endif
                </div>
                @if(!is_null($business_item->getImageRouteGuide))
                    <div class="col-12 col-lg-10 offset-lg-1 mt-3">
                        <img src="{{ App\Models\Base::getUploadURL($business_item->getImageRouteGuide->name, $business_item->getImageRouteGuide->dir) }}" alt="{{ $business_item->name }}" class="img-fluid m-auto">
                    </div>
                @endif
            </div>
        @else
            <div class="d-grid x1 xr4 g-3 g-lg-4 h-100">
                <div class="business-detail-map-item active p-2 h-100">
                    <div class="row h-100" data-id="0">
                        <div class="pr-0 {{ !is_null($business_item->getImageRouteGuide) ? 'col-8 col-lg-10' : 'col-12' }} d-flex flex-wrap align-items-center">
                            <a data-map="{{ $business_item->map }}" href="#" title="{{ $business_item->address }}" data-id="0" data-map="{{ $business_item->map }}">
                                <h4 class="address">{{ $business_item->address }}</h4>
                            </a>
                            @if (!empty($business_item->route_guide))
                                <a href="#" title="{{ $business_item->route_guide }}" data-id="0" data-map="{{ $business_item->map }}">
                                    <p class="m-0">{{ $business_item->route_guide }}</p>
                                </a>
                            @endif
                        </div>
                        @if (!is_null($business_item->getImageRouteGuide))
                            <div class="col-4 col-lg-2 d-flex flex-wrap align-items-center">
                                <a href="#" class="preview position-relative" data-id="0" data-map="{{ $business_item->map }}">
                                    <img src="{{ App\Models\Base::getUploadURL($business_item->getImageRouteGuide->name, $business_item->getImageRouteGuide->dir) }}" alt="" class="img-fluid rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @foreach ($business_item->getMapList as $map)
                    <div class="business-detail-map-item p-2 h-100">
                        <div class="row h-100" data-id="{{ $map->id }}">
                            <div class="pr-0 {{ !is_null($map->getImage) ? 'col-8 col-lg-10' : 'col-12' }} d-flex flex-wrap align-items-center">
                                <a data-map="{{ $map->map }}" href="#" title="{{ $map->address }}" data-id="{{ $map->id }}">
                                    <h4 class="address">{{ $map->address }}</h4>
                                </a>
                                @if (!empty($map->route_guide))
                                    <a data-map="{{ $map->map }}" href="#" title="{{ $map->route_guide }}" data-id="{{ $map->id }}">
                                        <p class="m-0">{{ $map->route_guide }}</p>
                                    </a>
                                @endif
                            </div>
                            @if (!is_null($map->getImage))
                                <div class="col-4 col-lg-2 d-flex flex-wrap align-items-center">
                                    <a href="#" class="preview position-relative" data-id="{{ $map->id }}" data-map="{{ $map->map }}">
                                        <img src="{{ App\Models\Base::getUploadURL($map->getImage->name, $map->getImage->dir) }}" alt="" class="img-fluid rounded-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="modal fade" id="image-route-guide-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <img src="{{ asset('images/poste/no-map.jpg') }}" class="img-fluid" alt="Image Route Guide">
                            <p class="text-center address"></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
