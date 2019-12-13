 <form action="{{ route('get_personal_trading_index_route') }}" method="GET">
    <p>Poste 検索は全ての書き込み情報が検索出来ます。</p>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="type_id" required>
                <option value="0">売り買い別表示...</option>
                @foreach ($personalTypeList as $item)
                <option value="{{ $item->id }}" {{ $typeIdSearch == $item->id ? 'selected' : '' }}>{{ $item->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="category_id" required>
                <option value="0">ジャンル別表示...</option>
                @foreach ($productCategoryList as $item)
                <option value="{{ $item->id }}" {{ $categoryIdSearch == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 input-group mb-3">
            <input type="text" class="form-control" placeholder="keywords" aria-label="keywords" aria-describedby="button-addon2" name="searchKeywords" value="{{ $searchKeywords }}">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</form>