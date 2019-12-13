<div class="container-fluid">
	<!-- sub-header bar -->
	<div class="row bg-dark d-none d-lg-block">
		<div class="container py-2">
			<span class="small text-white">POSTE(ポステ)はミャンマーの飲食店、居酒屋、不動産、求人、カラオケ、マッサージなどの生活情報コミュニティサイトです。</span>
		</div>
	</div>

	<!-- main-header bar -->
	<div class="row bg-white d-none d-lg-block border-bottom">
		<div class="container">
			<div class="row gap-3">
				<div class="col-3 py-3">
					<a href="{{ URL::to('/') }}">
						<img src="{{ asset('images/poste/logo.png') }}" class="img-fluid">
					</a>
				</div>
				<div class="col-6 py-3">
                    @isset($ad_home_pc_top_list)
                        @foreach ($ad_home_pc_top_list as $item)
                            <a href="{{ route('redirect_route').'?href='.$item->link.'&utm_campaign='.$item->utm_campaign.'&utm_source=poste-mm&utm_medium=banner' }}" target="_blank">
                                <img src="{{ App\Models\Base::getUploadURL($item->getImage->name, $item->getImage->dir) }}" class="img-fluid img-cover rounded shadow-sm hover" alt="{{ $item->name.','.$item->description }}">
                            </a>
                        @endforeach
                    @endisset
				</div>
				<div id="login" class="col-3 py-3">
					<div id="user-info" class="bg-grey d-flex h-100 flex-column justify-content-between rounded position-relative">
						@auth
						@include('www.includes.info-panel')
						@endauth

						@guest
						@include('www.includes.header-login-form')
						@endguest
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
