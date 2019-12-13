

<div class="p-3 p-lg-4 d-grid x2 x4-lg g-3">
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#space-tab" id="ga-space" class="text-dark">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                @if($space_images->count() > 0)
                    @php
                    $first_image = $space_images->first();
                    @endphp
                    <img src="{{ App\Models\Base::getUploadURL($first_image->name, $first_image->dir) }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @else
                    <img src="{{ asset('images/poste/blank.svg') }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @endif
            </div>
        </div>
        <strong>Space</strong>
        <small class="text-secondary">{{ $space_images->count() }} photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#food-tab" id="ga-food" class="text-dark">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                @if($food_images->count() > 0)
                    @php
                    $first_image = $food_images->first();
                    @endphp
                    <img src="{{ App\Models\Base::getUploadURL($first_image->name, $first_image->dir) }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @else
                    <img src="{{ asset('images/poste/blank.svg') }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @endif
            </div>
        </div>
        <strong>Food</strong>
        <small class="text-secondary">{{ $food_images->count() }} photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#menu-tab" id="ga-menu" class="text-dark">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                @if($menu_images->count() > 0)
                    @php
                    $first_image = $menu_images->first();
                    @endphp
                    <img src="{{ App\Models\Base::getUploadURL($first_image->name, $first_image->dir) }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @else
                    <img src="{{ asset('images/poste/blank.svg') }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @endif
            </div>
        </div>
        <strong>Menu</strong>
        <small class="text-secondary">{{ $menu_images->count() }} photos</small>
    </a>
    <a href="#gallerybox" data-toggle="modal" data-target="#gallerybox" data-albums="#general-tab" id="ga-general" class="text-dark">
        <div class="alb-thumb">
            <div class="media-wrapper-1x1 bg-grey">
                @if($general_images->count() > 0)
                    @php
                    $first_image = $general_images->first();
                    @endphp
                    <img src="{{ App\Models\Base::getUploadURL($first_image->name, $first_image->dir) }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @else
                    <img src="{{ asset('images/poste/blank.svg') }}" class="img-cover" alt="{{ $article->name }} - Space Images">
                @endif
            </div>
        </div>
        <strong>General</strong>
        <small class="text-secondary">{{ $general_images->count() }} photos</small>
    </a>
</div>

<div class="modal fade" id="gallerybox" aria-hidden="true" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Albums</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="space-tab" data-toggle="tab" href="#space-panel" role="tab" aria-controls="space-panel" aria-selected="false">Space</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="food-tab" data-toggle="tab" href="#food-panel" role="tab" aria-controls="food-panel" aria-selected="false">Food</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="menu-tab" data-toggle="tab" href="#menu-panel" role="tab" aria-controls="menu-panel" aria-selected="false">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="general-tab" data-toggle="tab" href="#general-panel" role="tab" aria-controls="general-panel" aria-selected="false">General</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="space-panel" role="tabpanel" aria-labelledby="space-tab">
                        <div id="space-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner mb-3">
                                @forelse ($space_images as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="img-contain" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center my-4">
                                        Don't have image about Space...
                                    </div>
                                @endforelse
                            </div>
                            @if($space_images->count() > 0)
                                <ol class="carousel-indicators">
                                    @foreach ($space_images as $key => $item)
                                        <li data-target="#space-slider" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                            <a class="carousel-control-prev" href="#space-slider" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#space-slider" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="food-panel" role="tabpanel" aria-labelledby="food-tab">
                        <div id="food-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner mb-3">
                                @forelse ($food_images as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="img-contain" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center my-4">
                                        Don't have image about Food...
                                    </div>
                                @endforelse
                            </div>
                            @if($food_images->count() > 0)
                                <ol class="carousel-indicators">
                                    @foreach ($food_images as $key => $item)
                                        <li data-target="#space-slider" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                            <a class="carousel-control-prev" href="#food-slider" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#food-slider" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="menu-panel" role="tabpanel" aria-labelledby="menu-tab">
                        <div id="menu-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner mb-3">
                                @forelse ($menu_images as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="img-contain" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center my-4">
                                        Don't have image about Menu...
                                    </div>
                                @endforelse
                            </div>
                            @if($menu_images->count() > 0)
                                <ol class="carousel-indicators">
                                    @foreach ($menu_images as $key => $item)
                                        <li data-target="#space-slider" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                            <a class="carousel-control-prev" href="#menu-slider" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#menu-slider" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="general-panel" role="tabpanel" aria-labelledby="general-tab">
                        <div id="general-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner mb-3">
                                @forelse ($general_images as $key => $item)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="img-contain" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                    </div>
                                @empty
                                    <div class="alert alert-warning text-center my-4">
                                        Don't have image about General...
                                    </div>
                                @endforelse
                            </div>
                            @if($general_images->count() > 0)
                                <ol class="carousel-indicators">
                                    @foreach ($general_images as $key => $item)
                                        <li data-target="#space-slider" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}">
                                            <img class="img-cover" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" alt="{{ $article->name }} | Space Image Carousel">
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                            <a class="carousel-control-prev" href="#general-slider" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#general-slider" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
