<div class="section-description my-4">
    日系企業の進出が相次ぐミャンマー。日本語の情報不足でビジネスチャンスを逃していませんか？ ポステが在ミャンマー企業とミャンマー進出予定の日系企業のプラットフォームとなり、ビジネスチャンスを拡大させます。
    <p class="m-0 text-secondary text-right">※無料で掲載可能です</p>
</div>
<div class="d-grid x3 xr3 g-2 g-lg-4">
    @foreach ($businessCategoryList as $item)
        <a href="{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}">
            <div class="btn-group w-100 h-100">
                <button type="button" class="btn btn-danger dropdown-toggle">
                    {{ $item->name }}
                </button>
                {{-- <div class="dropdown-menu">
                    @foreach ($item->getChildrenCategory as $child)
                        <a class="dropdown-item" href="{{ route('get_business_category_route', $child->slug.'-'.$child->id) }}" target="_blank">{{ $child->name }}</a>
                    @endforeach
                </div> --}}
            </div>
        </a>
    @endforeach
</div>
