<!-- main menu bar -->
<div class="container py-2 py-lg-0">
	<nav class="navbar navbar-expand-lg navbar-light bg-none p-0">
		<div id="navbar-brand" class="col-auto pl-0 pr-0 pr-lg-3 d-block d-lg-none">
			<a class="navbar-brand m-0" href="{{ URL::to('/') }}">
				<img id="logo" src="{{ asset('images/poste/logo.png') }}" class="img-fluid">
			</a>
		</div>
		<div id="social-buttons" class="d-grid d-lg-none g-gap-1 col">
			<div class="d-grid g-gap-1 grid-columns-2">
				@guest
					<a href="{{ route('login') }}" class="btn btn-sm btn-success">ログイン</a>
					<a href="{{ route('register') }}" class="btn btn-sm btn-danger">登録</a>
				@endguest
				@auth
					<a class="g-col-2 text-truncate text-center" href="{{ route('get_user_setting_index_route') }}">{{ getUsername(Auth::user()) }} さん</a>
					<a href="{{ route('get_user_setting_index_route') }}" class="btn btn-sm btn-success">Profile</a>
					<a href="#" class="btn btn-sm btn-danger btn-logout">ログアウト</a>
					@include('auth.logout-form')
				@endauth
			</div>
		</div>
		<div class="col-auto p-0 d-block d-lg-none">
			<button class="navbar-toggler p-2 p-sm-3 rounded-circle" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse gap-3" id="navbarNav">
			<div class="form-inline my-2 my-lg-0 col-12 col-lg-3 order-lg-2">
				<script>
				(function() {
					var cx = '004420610793479560034:d8q_v_rqsfi';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				})();
				</script>
				<gcse:search></gcse:search>
			</div>
		<ul class="navbar-nav nav-fill col gap-3 pl-4 pl-lg-0 order-lg-1">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('construction_route') }}"><span>おすすめ</span><span>スポット</span></a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown"><span>POSTE</span><span>タウン</span></a>
				<div class="dropdown-menu flex-lg-nowrap m-0 rounded-top-0 rounded-bottom">
					@foreach ($posteTownCategoryList as $item)
						@if($loop->index < 6)
							@if($loop->first)
								<div class="col-12 col-sm-6 col-lg p-0">
								@endif
								<a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
								{{-- <a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('construction_route') }}">{{ $item->name }}</a> --}}
								@if($loop->index == 5)
								</div>
							@endif
						@else
							@if($loop->index == 6)
								<div class="col-12 col-sm-6 col-lg p-0">
								@endif
								<a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('get_town_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
								{{-- <a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('construction_route') }}">{{ $item->name }}</a> --}}
								@if($loop->last)
								</div>
							@endif
						@endif
					@endforeach
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown"><span>クラシ</span><span>ファイド</span></a>
				<div class="dropdown-menu m-0 rounded-top-0 rounded-bottom">
					<a class="dropdown-item" href="{{ route('get_personal_trading_index_route') }}">個人売買</a>
					<a class="dropdown-item" href="{{ route('get_real_estate_index_route') }}">不動産情報</a>
					<a class="dropdown-item" href="{{ route('get_jobsearching_index_route') }}">お仕事探し</a>
					<a class="dropdown-item" href="{{ route('get_bullboard_index_route') }}">情報掲示板</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown"><span>暮らしの</span><span>知恵</span></a>
				<div class="dropdown-menu m-0 rounded-top-0 rounded-bottom">
					@foreach ($lifetipCategoryList as $item)
						<a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('get_lifetip_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
					@endforeach
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown">進出企業</a>
				<div class="dropdown-menu m-0 rounded-top-0 rounded-bottom">
					@foreach ($businessCategoryList as $item)
						{{-- <a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a> --}}
						<a class="dropdown-item {{ $item->datecount < 7 ? 'new' : '' }}" href="{{ route('get_business_category_route', $item->slug.'-'.$item->id) }}">{{ $item->name }}</a>
					@endforeach
				</div>
			</li>
		</ul>
	</div>
</nav>
</div>
