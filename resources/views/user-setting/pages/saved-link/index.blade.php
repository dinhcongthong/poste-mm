@extends('user-setting.layouts.masterGlobal')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{{ asset('user-setting/css/saved-links.css') }}">
@endsection

@section('content')

    <div id="user-summary" class="g-col-4 g-col-md-3">
        <div style="min-height:calc(100vh - 120px);">
            <h4>Saved Links</h4>
            <div class="row">
                <div class="col-12 my-4 saved-list d-flex flex-wrap">
                    <input class="col-auto form-check-input _town" type="checkbox" id="inlineCheckbox1" value="town" checked>
                    <label class="col-auto form-check-label the_town" for="inlineCheckbox1">Town</label>
                    <input class="col-auto form-check-input _business" type="checkbox" id="inlineCheckbox2" value="business" checked>
                    <label class="col-auto form-check-label the_business" for="inlineCheckbox2">Business</label>

                    <div class="col-auto" style="width: 100%;">
                        <span class="clearable" style="width: inherit;">
                            <input class=" form-control typeahead" type="text" id="name_post" name="name_post" placeholder="Type to search">
                            <i class="clearable__clear">&times;</i>
                        </span>
                    </div>

                    <div class="w-100"></div>

                    <div id="sort" style="width: 100%;"></div>

                    <h6 class="saved-timeline">最近</h6>
                    <div id="post_data_recent" style="width: 100%;">
                        @foreach($recent_list as $item)
                            @include('user-setting.pages.saved-link.data-section')
                        @endforeach
                    </div>

                    <h6 class="saved-timeline">昔</h6>
                    <div id="post_data_ago" style="width: 100%;">
                        @foreach($ago_list as $item)
                            @include('user-setting.pages.saved-link.data-section')
                        @endforeach
                    </div>
                    @if($ago_list->currentPage() < $ago_list->lastPage())
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-info rounded-pill" data-page="{{ $ago_list->currentPage() }}" id="load-more-button">Load more...</button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('user-setting/js/saved-links.js') }}"></script>
@endsection
