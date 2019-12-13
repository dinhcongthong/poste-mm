<div class="section-description">
    困ったとき、いざというときに。ミャンマー・ヤンゴン生活で暮らしに役立つ情報満載！
    あなたの街のポータルサイト「POSTEタウン」。誰でも無料でレストランやカフェなどの飲食店からクラブやディスコなどのナイトスポット情報までご登録いただけます！
    <p class="m-0 text-secondary text-right">※無料で掲載可能です</p>
</div>
<div class="d-grid g-2 g-lg-4">
    <a href="{{ route('get_town_index_route') }}" target="_blank" class="town-item town1 btn btn-light">おすすめ</a>
    @foreach ($posteTownCategoryList as $item)
    <a href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}" target="_blank" class="town-item town{{ $loop->iteration + 1 }} btn btn-light">{{ $item->name }}</a>
    @endforeach
</div>