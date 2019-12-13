<div id="scrollspy" class="g-col-3 d-none d-lg-block">
    <div class="sticky-top sticky-top-except-nav">
        <div id="premium-info-list" class="list-group scrollspy-bar mb-3">
            <a class="list-group-item list-group-item-action" href="#about"><i class="fas fa-bullhorn"></i>概要 <i>（Description）</i></a>
            @if(isset($working_time))
            <a class="list-group-item list-group-item-action" href="#working-time"><i class="far fa-clock"></i>営業時間 <i>（Working time）</i></a>
            @endif
            @unless ($category_item->id == 73)
            <a class="list-group-item list-group-item-action" href="#features"> <i class="fas fa-list-ol"></i>特徴 <i>(Feature)</i></a>
            @endunless
            @if(!in_array($category_item->id, array(70, 74)))
            <a class="list-group-item list-group-item-action" href="#menu"><i class="fas fa-layer-group"></i>メニュー <i>{{ in_array($category_item->id, array(68, 71, 72, 73)) ? '(Menu)' : '(Products)' }}</i></a>
            @endif
            <a class="list-group-item list-group-item-action" href="#gallery"><i class="far fa-images"></i>写真 <i>(Images)</i></a>
            <a class="list-group-item list-group-item-action" href="#map"><i class="fas fa-map-marked-alt"></i>マップ <i>(Map)</i></a>
        </div>
        <div>
            <button type="submit" class="btn btn-success btn-block mb-1"><i class="far fa-save"></i> 保存（Save）</button>
            <a href="{{ route('get_town_new_route') }}" class="btn btn-danger btn-block"><i class="fas fa-backward"></i> 一覧ページへ戻る（Back） </a>
        </div>
    </div>
</div>