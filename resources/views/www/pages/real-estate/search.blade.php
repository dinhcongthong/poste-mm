<form action="{{ route('get_real_estate_index_route') }}" method="GET">
    <p>Poste 検索は全ての書き込み情報が検索出来ます。</p>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="type_search_id">
                <option value="0">目的別...</option>
                @foreach ($realestate_type_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $type_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="price_search_id">
                <option value="0">料金...</option>
                 @foreach ($realestate_price_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $price_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="bedroom_search_id">
                <option value="0">間取りから探す...</option>
                  @foreach ($realestate_bedroom_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $bedroom_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="category_search_id">
                <option value="">物件タイプ...</option>
                @foreach ($realestate_category_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $category_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-8 input-group mb-3">
            <input type="text" class="form-control" placeholder="keywords" aria-label="keywords" aria-describedby="button-addon2" name="searchKeywords" value="{{ $searchKeywords }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</form>