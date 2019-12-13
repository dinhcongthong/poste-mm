<ul class="nav nav-pills nav-justified w-100 h-100">
    <li class="nav-item">
        <a class="nav-link" href="#about">
            <i class="fas fa-bullhorn"></i>
            概要 <span class="font-italic">（Description）</span>
        </a>
    </li>
    @if(isset($working_time))
    <li class="nav-item">
        <a class="nav-link" href="#working-time">
            <i class="far fa-clock"></i>
            営業時間 <span class="font-italic">（Working time）</span>
        </a>
    </li>
    @endif
    @unless ($category_item->id == 73)        
    <li class="nav-item">
        <a class="nav-link" href="#features">
            <i class="fas fa-list-ol"></i>
            特徴 <span class="font-italic">(Feature)</span>
        </a>
    </li>
    @endunless
    @if(!in_array($category_item->id, array(70, 74)))
    <li class="nav-item">
        <a class="nav-link" href="#menu">
            <i class="fas fa-layer-group"></i>
            メニュー <span class="font-italic">{{ in_array($category_item->id, array(68, 71, 72, 73)) ? '(Menu)' : '(Products)' }}</span>
        </a>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="#gallery">
            <i class="far fa-images"></i>
            写真 <span class="font-italic">(Images)</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#map">
            <i class="fas fa-map-marked-alt"></i>
            マップ
        </a>
    </li>
</ul>