@extends('www.layouts.master')

@section('content')
<div id="golf-detail">
    <div class="container">
        <div id="breadcrumb" class="mb-4 d-none d-md-block">
            <ol class="breadcrumb  bg-white">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('get_golf_index_route') }}">Golf</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $article->name }}</li>
            </ol>
        </div>
        <div id="main-detail" class="bg-white mb-4 p-4">
            <div class="title clearfix">
                <h2 class="font-weight-bold">{{ $article->name }}</h2>
                <div class="clearfix" id="social-share-button">
                    @include('www.includes.social-share-button')
                </div>
                <span class="float-right update_at">{{ date('Y年m月d日', strtotime($article->update_at)) }}</span>
            </div>
            <hr class="w-50 mt-1">
            <div class="content">
                <div class="row mb-4">
                    <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                        <img class="img-fluid w-100" src="{{ App\Models\Base::getUploadURL($article->getThumbnail->name, $article->getThumbnail->dir) }}" alt="{{ $article->name }}">
                    </div>
                </div>
                <div class="golf-info mb-4">
                    <h3 class="font-weight-bold">—コース紹介</h3>
                    <p class="m-0">
                        {!! $article->description !!}
                    </p>
                </div>
                <div class="mb-4">
                    <table class="table table-bordered table-striped table-hover" id="table-info">
                        <tbody>
                            <tr>
                                <td>住所</td>
                                <td>
                                    {{ $article->address }}
                                    @unless (is_null($article->getDistrict))
                                    {{ ', '.$article->getDistrict->name }}
                                    @endunless
                                    @unless (is_null($article->getCity))
                                    {{ ', '.$article->getCity->name }}
                                    @endunless
                                </td>
                            </tr>
                            <tr>
                                <td>電話番号</td>
                                <td>{{ $article->phone }}</td>
                            </tr>
                            <tr>
                                <td>営業時間</td>
                                <td>{{ $article->work_time }}</td>
                            </tr>
                            @empty (!$article->budget)  
                            <tr>
                                <td>予算</td>
                                <td>{{ $article->budget }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->yard)    
                            <tr>
                                <td>ヤード</td>
                                <td>{{ $article->yard }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->caddy)    
                            <tr>
                                <td>キャディ付き添い</td>
                                <td>{{ $article->caddy }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->rental)    
                            <tr>
                                <td>道具レンタル</td>
                                <td>{{ $article->rental }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->cart)   
                            <tr>
                                <td>カート</td>
                                <td>{{ $article->cart }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->facility)   
                            <tr>
                                <td>設備</td>
                                <td>{{ $article->facility }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->shower)
                            <tr>
                                <td>シャワー</td>
                                <td>{{ $article->shower }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->lesson)
                            <tr>
                                <td>ゴルフレッスン</td>
                                <td>{{ $article->lesson }}</td>
                            </tr>
                            @endempty
                            @empty (!$article->golf_station_number)
                            <tr>
                                <td>ゴルフコース数</td>
                                <td>{{ $article->golf_station_number }}</td>
                            </tr>
                            @endempty
                            @empty(!$article->website)    
                            <tr>
                                <td>HP</td>
                                <td>
                                    <a href="{{ $article->website }}" target="_blank">{{ $article->website }}</a>
                                </td>
                            </tr>
                            @endempty
                        </tbody>
                    </table>
                </div>
                @empty(!$article->map)
                @if(strpos($article->map, ','))
                <div class="mb-4 map-no-info">
                    <iframe width="100%" name="frame-map" id="frame-map" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&q={{ $article->map }}" allowfullscreen></iframe>
                </div>
                @else
                <div class="mb-4">
                    <iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_API_KEY') }}&q=place_id:{{ $article->map }}" allowfullscreen></iframe>
                </div>
                @endif
                {{-- </div> --}}
                @endempty
                @if($article->getImageGolfList->count() > 0)
                <div class="golf-info mb-4">
                    <h3 class="font-weight-bold">ギャラリー</h3>
                    <div class="d-grid x2 x4-lg x3-md g-4" id="popup-image">
                        @foreach ($article->getImageGolfList as $item)    
                        <a href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" title="{{ $article->name }}">
                            <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}">
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection