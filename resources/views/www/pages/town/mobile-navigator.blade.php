<div class="row border-top w-100 m-0" style="height: 60px;">
    <a class="col nav-link text-center" data-toggle="collapse" href="#premium-nav-mobile" role="button" aria-expanded="false" aria-controls="premium-nav-mobile"><i class="material-icons d-block">tune</i><small>Categories</small></a>
    <a class="col nav-link text-center" data-toggle="collapse" href="#premiumSearch" role="button" aria-expanded="false" aria-controls="premiumSearch"><i class="material-icons d-block">search</i><small>Search</small></a>

    @if(Request::segment(2) != 'new' && Request::segment(2) != '' && Request::segment(2) != 'edit' && Request::segment(2) != 'category' && Request::segment(2) != 'tag')
    @if(Auth::check() && (Auth::user()->type_id == App\Models\User::TYPE_ADMIN || ($article->owner_id != 0 && Auth::user()->id == $article->owner_id)))
    <a href="{{ route('get_town_edit_route', $article->slug.'-'.$article->id) }}" class="col btn btn-danger text-center"><i class="material-icons d-block">add_location</i><small>Edit this page</small></a>
    @endif

    @endif

</div>
<div class="collapse bg-white col-12 p-0" id="premium-nav-mobile" data-parent=".premium-nav-mobile">
    <div id="premium-filter" class="list-group">
        @foreach ($posteTownCategoryList as $item)
        <a href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}" class="list-group-item list-group-item-action town{{ $loop->iteration+1 }} active">{{ $item->name }}</a>
        @endforeach
    </div>
</div>
<div class="collapse bg-white col-12 p-3" id="premiumSearch" data-parent=".premium-nav-mobile">
    <form class="form-inline" action="{{ route('get_town_index_route') }}" method="GET">
        @csrf
        <select name="search_category" class="col-12 col-md form-control custom-select border-bottom h-auto py-3 py-md-1 px-3 mb-15" id="category-select">
            <option value="0">Choose Category...</option>
            @foreach ($posteTownCategoryList as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        <input id="b-search-input" class="form-control mr-sm-2" name="keywords" type="search" placeholder="Enter keyword..." aria-label="Search">
    </form>
</div>
