<form action="{{ route('get_bullboard_index_route') }}" method="GET">
    <p>Poste 検索は全ての書き込み情報が検索出来ます。</p>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="category_id">
                <option value="0">情報別...</option>
                @foreach ($bullboardCategoryList as $item)
                <option value="{{ $item->id }}" {{ $categoryIdSearch == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-8 input-group mb-3">
            <input type="text" class="form-control" placeholder="keywords" aria-label="keywords" aria-describedby="button-addon2" value="{{ $searchKeywords }}" name="searchKeywords">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</form>