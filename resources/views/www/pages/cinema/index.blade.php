@extends('www.layouts.master')

@section('content')
<div class="container mb-4">
    <div class="bg-white">
        <div class="p-3 pb-0">
            <div class="row">
                <div class="col-12 d-grid g-4 x5-lg x6">
                    <a href="{{ Request()->url() }}" class="show-date w-100 btn btn-outline-primary {{ $show_date == date('Y-m-d') ? 'active' : '' }}">{{ date('Y-m-d') }}</a>
                    <a href="{{ Request()->url().'?show_date='.date('Y-m-d', strtotime('+1 days')) }}" class="show-date w-100 btn btn-outline-primary {{ $show_date == date('Y-m-d', strtotime('+1 days')) ? 'active' : '' }}">{{ date('Y-m-d', strtotime('+1 days')) }}</a>
                    <a href="{{ Request()->url().'?show_date='.date('Y-m-d', strtotime('+2 days')) }}" class="show-date w-100 btn btn-outline-primary {{ $show_date == date('Y-m-d', strtotime('+2 days')) ? 'active' : '' }}">{{ date('Y-m-d', strtotime('+2 days')) }}</a>
                    <a href="{{ Request()->url().'?show_date='.date('Y-m-d', strtotime('+3 days')) }}" class="show-date w-100 btn btn-outline-primary {{ $show_date == date('Y-m-d', strtotime('+3 days')) ? 'active' : '' }}">{{ date('Y-m-d', strtotime('+3 days')) }}</a>
                    <a href="{{ Request()->url().'?show_date='.date('Y-m-d', strtotime('+4 days')) }}" class="show-date w-100 btn btn-outline-primary {{ $show_date == date('Y-m-d', strtotime('+4 days')) ? 'active' : '' }}">{{ date('Y-m-d', strtotime('+4 days')) }}</a>
                </div>
            </div>
        </div>
        <div class="p-3 pt-0" id="cinema-content">
            @forelse ($movieList as $item)
            <div class="movie-item">
                <div class="row">
                    <div class="col-12 col-md-3 pr-md-2 text-center">
                        <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($item->getThumbnail->name, $item->getThumbnail->dir) }}" alt="film1">
                    </div>
                    <div class="col-12 col-md-9 pl-sm-2 mt-2 mt-md-0">
                        <h2 class="title font-weight-bold">{{ $item->name }} </h2>
                        <div class="row">
                            <div class="col-12 col-md-7">
                                <p class="info">
                                    <b>公開日: </b> {{ date('Y-m-d', strtotime($item->published_at)) }}<br/>
                                    @empty(!$item->actors)
                                    <b>出演者: </b> {{ $item->actors }} <br/>
                                    @endempty
                                    @empty(!$item->genres)
                                    <b>映画ジャンル: </b> {{ $item->genres }}
                                    @endempty
                                </p>
                                <p class="des">
                                    {!! $item->description !!}
                                </p>
                                @empty(!$item->trailer_youtube_id)
                                <div class="d-grid x1 x2-md">
                                    <button type="button" data-toggle="modal" data-target="#trailer" data-trailer="{{ $item->trailer_youtube_id }}" class="btn btn-outline-primary btn-block btn-lg m-0 mb-3 mb-md-0 btn-trailer">Trailer</button>
                                </div>
                                @endempty 
                            </div>
                            
                            <div class="col-12 col-md-5 d-flex flex-wrap flex-items-center">
                                @foreach ($theaterList as $theater)
                                <a href="#schedule-{{ $item->id.'-'.$theater->id}}" data-toggle="modal">
                                    @isset($theater->getThumbnail)
                                    <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($theater->getThumbnail->name, $theater->getThumbnail->dir) }}" alt="{{ $theater->name }}">
                                    @else
                                    <img class="img-fluid" src="{{ asset('images/poste/demo/bhd-cinema.jpg') }}" alt="{{ $theater->name }}">
                                    @endisset
                                </a>
                                
                                
                                {{-- Modal Schedule --}}
                                <div class="modal fade" tabindex="-1" role="dialog" id="schedule-{{ $item->id.'-'.$theater->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">ルイスと不思議の時計【今週のシネマ】 </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container-fluid px-0">
                                                    <div class="col-12 mb-4">
                                                        <div class="theater-image mb-2 text-center">
                                                            @isset($theater->getThumbnail)
                                                            <img class="img-fluid" src="{{ App\Models\Base::getUploadURL($theater->getThumbnail->name, $theater->getThumbnail->dir) }}" alt="{{ $theater->name }}">
                                                            @else
                                                            <img class="img-fluid" src="{{ asset('images/poste/demo/bhd-cinema.jpg') }}" alt="{{ $theater->name }}">
                                                            @endisset
                                                        </div>
                                                        <div class="show-list">
                                                            @foreach ($theater->getChildTheater as $position)
                                                            @php 
                                                            // Get Lich Chieu tai rap do
                                                            $showItem = $item->getShowTimes->where('position_id', $position->id)->first();
                                                            @endphp
                                                            @if(!is_null($showItem))
                                                            <h4 class="border border-primary border-top-0 border-right-0 border-left-0">{{ $position->name }}</h4>
                                                            <div class="show-item mb-4">
                                                                <div class="d-grid gx-4 gy-2 x9-lg x3 x5-sm x6-md">
                                                                    @php
                                                                    $showHoursList = explode(',', $showItem->show_hours);
                                                                    date_default_timezone_set('Asia/Yangon');
                                                                    $curtime = date('H:i');
                                                                    @endphp
                                                                    @foreach ($showHoursList as $show)
                                                                    <span class="btn {{ $curtime > $show ? 'btn-secondary' : ($show <= '12:00' ? 'btn-success' : 'btn-warning') }}">{{ $show }}</span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Schedule --}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-light">We have not update Movie... Sorry very much</div>
            @endforelse
        </div>
    </div>
</div>
{{-- Modal trailer --}}
<div class="modal fade" tabindex="-1" role="dialog" id="trailer">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="trailer-frame" width="100%" height="500" src="https://www.youtube.com/embed/lD364zmok1M" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                {{--  <button type="button" class="btn btn-outline-secondary btn-block d-md-none px-1 py-2" data-dismiss="modal" aria-label="Close" style="font-size: 1.2rem;">
                    Close
                </button> --}}
            </div>
        </div>
    </div>
</div>
{{-- End Modal trailer --}}
@endsection