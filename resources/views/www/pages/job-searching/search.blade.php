<form action="{{ route('get_jobsearching_index_route') }}" method="GET">
    <p>Poste 検索は全ての書き込み情報が検索出来ます。</p>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="type_search_id">
                <option value="0">雇用形態...</option>
                @foreach ($job_searching_type_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $type_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="category_serch_id">
                <option value="0">職種...</option>
                @foreach ($job_searching_category_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $category_serch_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="nationality_search_id">
                <option value="0">雇用国籍...</option>
                @foreach ($job_searching_employee_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $nationality_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <select class="form-control" name="nationality_search_id">
                <option value="0">雇用国籍...</option>
                @foreach ($job_searching_employee_list as $item)
                <option value="{{ $item->id }}" {{ $item->id == $nationality_search_id ? 'selected' : '' }}>{{ $item->name }}</option>
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