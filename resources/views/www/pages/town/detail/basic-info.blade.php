<div class="col-12 col-lg-5 p-0">
    <div class="h-100 w-100 thumb">
        <img src="{{ App\Models\Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir) }}" class="img-cover" alt="{{ $article->name }}">
    </div>
</div>
<div class="col-12 col-lg-7 p-3 position-relative">
    <div class="basic-line">
        <div class="row">
            <div class="col-12 col-lg-8">
                @if($article->getTagList->count() > 0)
                    <div class="area-list">
                        foreach ($article->getTagList as $tag)
                            <a href="{{ route('get_town_tag_route', $tag->slug.'-'.$tag->id) }}" class="tag">{{ $tag->name }}</a>
                        endforeach
                    </div>
                @endif

                <h2 class="shop-name">{{ $article->name }}</h2>
            </div>
            <div class="col-12 col-lg-4 d-flex align-self-center mt-3 mt-lg-0">
                <button class="col btn {{ $liked ? 'btn-saved' : 'btn-save' }}" data-toggle="modal" data-target="#save-modal" data-id="{{ $article->id }}" data-type="town" id="btn-save">Save</button>
                {{-- <button class="col btn btn-share">Share</button> --}}
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
            <div class="col-12 mt-3 mt-lg-0 shop-addr">
                <a href="#map" class="street-addr">{{ $article->address.' '.$article->getCity->name }}</a>
            </div>
            @if(!empty($article->route_guide))
                <div class="col-12 mt-3 mt-lg-0 shop-route-guide">
                    <i class="fas fa-route"></i>
                    <a href="#map" class="extended-addr text-truncate">{{ $article->route_guide }}</a>
                </div>
            @endif
            @if($article->category_id !== 70 )
                @include('www.pages.town.detail.working-time')
            @endif
            @if(!empty($article->phone))
                @php
                $phoneArray = explode(",", $article->phone);
                @endphp
                <div class="col-12 mt-3 mt-lg-0 shop-phone d-flex flex-wrap">
                    @foreach ($phoneArray as $phone)
                        @php $phone = trim($phone); @endphp
                        <span><a href="tel:{{ $article->phone }}" class="text-dark" style="padding-right: 15px; display: inline;">{{ $phone }}</a></span><span style="padding-right: 15px;"> | </span>
                    @endforeach
                </div>
            @endif
            <div class="col-12 shop-pay flex-wrap px-0">
                @if(!empty($article->budget))
                    <div class="col-12 mt-3 mt-lg-0 col-lg-auto budget">{{ $article->budget }}</div>
                @endif
                <div class="col-12 mt-3 mt-lg-0 col-lg-auto currency">
                    @php
                    $currencies = explode(',', $article->currency);
                    @endphp
                    <span class="{{ !in_array(33, $currencies) ? 'disable' : '' }}" title="Kyat">MMK</span>
                    <span class="{{ !in_array(34, $currencies) ? 'disable' : '' }}" title="US Dollar">USD</span>
                    <span class="{{ !in_array(35, $currencies) ? 'disable' : '' }}" title="Yen">JPY</span>
                </div>
                <div class="col-12 mt-3 mt-lg-0 col-lg-auto credit-card">
                    @php
                    $credits = explode(',', $article->credit);
                    @endphp
                    <i class="fab fa-cc-visa fa-2x {{ !in_array(28, $credits) ? 'disable' : '' }}" title="Visa Card"></i>
                    <i class="fab fa-cc-mastercard fa-2x {{ !in_array(29, $credits) ? 'disable' : '' }}" title="Master Card"></i>
                    <i class="fab fa-cc-jcb fa-2x {{ !in_array(30, $credits) ? 'disable' : '' }}" title="JCB Card"></i>
                    <span class="{{ !in_array(57, $credits) ? 'disable' : '' }} mpu-card">
                        <img src="{{ asset('images/poste/mpu.svg') }}" style="width: 2.28rem;" alt="MPU Card">
                    </span>
                    <span class="{{ !in_array(58, $credits) ? 'disable' : '' }} mpu-card">
                        <img src="{{ asset('images/poste/unionpay.svg') }}" style="width: 2.28rem;" alt="Unionpay Card">
                    </span>
                </div>
            </div>
            <div class="col-12 shop-social flex-wrap px-0">
                @if(!empty($article->email))
                    <a href="mailto:{{ $article->email }}" class="col-12 col-lg-auto mt-3 mt-lg-0 nav-link email">{{ $article->email }}</a>
                @endif
                @if(!empty($article->website))
                    <a href="{{ $article->website }}" class="col-12 col-lg-auto mt-3 mt-lg-0 nav-link web" target="_blank">Website</a>
                @endif
                @if(!empty($article->facebook))
                    <a href="{{ $article->facebook }}" class="col-12 col-lg-auto mt-3 mt-lg-0 nav-link fb" target="_blank">Facebook</a>
                @endif
            </div>
        </div>
    </div>
    <div class="position-absolute px-3 pb-2 features-line" style="overflow: hidden;">
        <div class="dropdown-divider"></div>
        <div class="row shop-feature" style="overflow: hidden;">
            <div class="col-8 col-md-10 pr-0">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @include('www.pages.town.detail.features')
                    </div>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
            <div class="col text-center">
                <a href="#features-detail-list" class="see-more-features w-100 text-center">
                    <button class="swiper-slide btn btn-light rounded-pill w-100">
                        <i class="material-icons">more_vert</i>
                        <span class="text font-weight-bold">詳細</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" id="save-modal"  role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="z-index: 10000;">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div id="saved-result" class="p-3 bg-success text-white" ></div>
    </div>
  </div>
</div>

<script type="text/javascript">
    setInterval(function(){
        $('#save-modal').modal('hide');
    }, 2000);
</script>
