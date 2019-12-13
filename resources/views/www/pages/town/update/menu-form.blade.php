<div class="text-center mb-4">
    Best Menu Image Size: <span class="text-danger font-weight-bold">W: 300px - H: 300px</span><br/>
    Max Menu Image File Size: <span class="text-danger font-weight-bold">2MB</span><br/>
    <span class="text-danger font-weight-bold">Food name always required</span>
</div>
<div id="menu-list-content">
    @forelse ($menu_list as $item)
        <form class="menu-form" data-count="{{ $loop->iteration }}" action="{{ route('post_town_new_route') }}" method="POST" id="menu-form-{{ $loop->iteration }}" enctype="multipart/form-data">
            <input type="hidden" value="{{ $item->id }}" name="menu_section_id">
            <div class="card mb-4" id="menu-section-{{ $loop->iteration }}">
                <div class="card-header">
                    <input type="text" class="form-control" name="food_section" value="{{ $item->name }}" placeholder="Food Group Name">
                </div>
                <div class="card-body">
                    <div id="menu-grid-{{ $loop->iteration }}" class="d-grid x1 x2-lg g-2 g-lg-3 mb-3">
                        @foreach ($item->getDetail as $detail)
                            <div class="food-item d-flex flex-wrap align-items-end" id="food-item-{{ $loop->iteration }}">
                                <input type="hidden" name="food_ids[]" value="{{ $detail->id }}">
                                <div class="row no-gutters">
                                    <div class="col-3 pr-2">
                                        <div class="media-wrapper-1x1">
                                            @if(!is_null($detail->getImage))
                                                <img class="img-cover" id="food-image-{{ $loop->iteration }}" src="{{ App\Models\Base::getUploadURL($detail->getImage->name, $detail->getImage->dir) }}" alt="{{ $detail->name }}">
                                            @else
                                                <img class="img-cover" id="food-image-{{ $loop->iteration }}" src="{{ asset('images/poste/blank.svg') }}" alt="{{ $detail->name }}">
                                            @endif
                                        </div>
                                        <div class="food-image-browse">
                                            <label class="w-100 text-center border m-0 bg-grey">Browse</label>
                                            <input type="file" name="food_image[]" data-count="{{ $loop->iteration }}" data-section="{{ $loop->parent->iteration }}" class="ip-food-image">
                                        </div>
                                    </div>
                                    <div class="col-9 d-flex pr-0 flex-wrap text-left">
                                        <input type="text" name="food_name[]" class="form-control" value="{{ $detail->name }}" placeholder="商品名（Name)">
                                        <input type="text" name="food_price[]" class="form-control" value="{{ $detail->price }}" placeholder="値段（Price)">
                                        <a href="#" class="ml-auto text-danger delete-food" data-id="{{ $detail->id }}" data-section="{{ $loop->parent->iteration }}" data-count="{{ $loop->iteration }}">削除（Delete）</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button"  class="btn btn-primary add-food" data-count="{{ $loop->iteration }}">Add Food Item</button>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger float-right delete-menu-section" data-id="{{ $item->id }}" data-section="{{ $loop->iteration }}">削除（Delete）</button>
                </div>
            </div>
        </form>
    @empty
        <form class="menu-form" data-count="1" action="{{ route('post_town_new_route') }}" method="POST" id="menu-form-1" enctype="multipart/form-data">
            <input type="hidden" value="0" name="menu_section_id">
            <div class="card mb-4" id="menu-section-1">
                <div class="card-header">
                    <input type="text" class="form-control" name="food_section" placeholder="グループ名（Group Name）">
                </div>
                <div class="card-body">
                    <div id="menu-grid-1" class="d-grid x1 x2-lg g-2 g-lg-3 mb-3">
                        <div class="food-item d-flex flex-wrap align-items-end" id="food-item-1">
                            <input type="hidden" name="food_ids[]" value="0">
                            <div class="row no-gutters">
                                <div class="col-3 pr-2">
                                    <div class="media-wrapper-1x1">
                                        <img class="img-cover" id="food-image-1" src="{{ asset('images/poste/blank.svg') }}" alt="food image">
                                    </div>
                                    <div class="food-image-browse">
                                        <label class="w-100 text-center border m-0 bg-grey">Browse</label>
                                        <input type="file" name="food_image[]" data-count="1" data-section="1" class="ip-food-image">
                                    </div>
                                </div>
                                <div class="col-9 d-flex pr-0 flex-wrap text-left">
                                    <input type="text" name="food_name[]" class="form-control" placeholder="商品名（Name)">
                                    <input type="text" name="food_price[]" class="form-control" placeholder="値段（Price)">
                                    <a href="#" class="ml-auto text-danger delete-food" data-id="0" data-section="1" data-count="1">削除（Delete）</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button"  class="btn btn-primary add-food" data-count="1">Add Food Item</button>
                </div>
                <div class="card-footer">
                    <button class="btn btn-danger float-right delete-menu-section" data-id="0" data-section="1">削除（Delete）</button>
                </div>
            </div>
        </form>
    @endforelse
</div>

<button type="button" class="btn btn-primary" id="add-food-section" data-count="{{ count($menu_list) > 0 ? $menu_list->count() : '1' }}">Add Food Group</button>
