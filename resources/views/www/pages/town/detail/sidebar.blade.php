<div id="premium-info-list" class="list-group sticky-top scrollspy-bar sticky-top-except-nav">
    <a class="list-group-item list-group-item-action" href="#about"><i class="fas fa-bullhorn"></i>概要</a>
    <a class="list-group-item list-group-item-action" href="#features-detail-list"><i class="fas fa-clipboard-list"></i>概要</a>
    @if(count($promotion_list) > 0)
        <a class="list-group-item list-group-item-action" href="#promotion"><i class="fas fa-gift"></i>耳寄り情報</a>
    @endif
    @if(!in_array($article->category_id, array(70, 74)) && !$menuList->isEmpty())
        <a class="list-group-item list-group-item-action" href="#menu"><i class="fas fa-layer-group"></i>メニュー</a>
    @endif
    @if(!$general_images->isEmpty())
        <a class="list-group-item list-group-item-action" href="#gallery"><i class="far fa-images"></i>写真</a>
    @endif
    @if(!empty($article->map))
        <a class="list-group-item list-group-item-action" href="#map"><i class="fas fa-map-marked-alt"></i>マップ</a>
    @endif
    <a class="list-group-item list-group-item-action text-primary" href="#feedback-modal" data-toggle="modal" data-target="#feedback-modal"><i class="fas fa-pen"></i>Improve this listing</a>
    @if(Request::segment(2) != 'new' && Request::segment(2) != '' && Request::segment(2) != 'edit' && Request::segment(2) != 'category')
        @if(Auth::check() && (Auth::user()->type_id == App\Models\User::TYPE_ADMIN || ($article->owner_id != 0 && Auth::user()->id == $article->owner_id)))
            <a  href="{{ route('get_town_edit_route', $article->slug.'-'.$article->id) }}" class="col btn btn-danger text-center"><i class="material-icons d-block">add_location</i><small>Edit this page</small></a>
        @endif
    @endif
</div>
