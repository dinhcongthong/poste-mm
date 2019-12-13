@extends('admin.layouts.master')

@section('content')
<div class="row py-2">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 text-center mb-3">
        <img class="img-fluid m-auto" src="{{ App\Models\Base::getUploadURL($gallery->name, $gallery->dir) }}">
    </div>
    <div class="col-12">

        <div class="row">
            @if($newsThumbnailList->isEmpty() &&
            $newsImageList->isEmpty() &&
            $categoryList->isEmpty() &&
            $theaterList->isEmpty() &&
            $adList->isEmpty() &&
            $golfList->isEmpty() &&
            $golfImageList->isEmpty() &&
            $personalFirstImages->isEmpty() &&
            $personalSecondImages->isEmpty() &&
            $bullboardFirstImage->isEmpty() &&
            $bullboardSecondImage->isEmpty() &&
            $realEstateFirstImage->isEmpty() &&
            $realEstateSecondImage->isEmpty() &&
            $userAvatar->isEmpty() &&
            $posteTown->isEmpty() &&
            $foodImageTown->isEmpty() &&
            $businessListFromAvatar->isEmpty() &&
            $businessListFormPrimaryMap->isEmpty() &&
            $businessMapList->isEmpty() &&
            $businessGalleries->isEmpty() )

            @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
            @endif

            <div class="col-12">
                <div class="alert alert-success mb-3">
                    You can delete this image......
                </div>
            </div>
            <form action="{{ route('post_gallery_delete_ad_route', ['id' => $gallery->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger mx-4">Delete</button>
            </form>
            @else
            <div class="col-12">
                <div class="alert alert-danger w-100 text-center mb-3">
                    You can not delete this image. <br/>
                    It is used by under articles.<br/>
                    Please check it.
                </div>
            </div>

            {{-- News Thumbnail --}}
            @if(!$newsThumbnailList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>News Thumbnails</b>
                        <a class="float-right text-primary" href="{{ route('get_lifetip_index_ad_route') }}" target="_blank">Lifetip page</a>
                        <a class="float-right text-primary mr-3" href="{{ route('get_dailyinfo_index_ad_route') }}" target="_blank">Dailyinfo page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsThumbnailList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- News List --}}
            @if(!$newsImageList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>News Image List</b>
                        <a class="float-right text-primary" href="{{ route('get_lifetip_index_ad_route') }}" target="_blank">Lifetip page</a>
                        <a class="float-right text-primary mr-3" href="{{ route('get_dailyinfo_index_ad_route') }}" target="_blank">Dailyinfo page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsImageList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif


            {{-- Category List --}}
            @if(!$categoryList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Cateogry List</b>
                        <a class="float-right text-primary" href="{{ route('get_category_index_ad_route') }}" target="_blank">Category page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoryList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Movie List --}}
            @if(!$movieList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Movie List</b>
                        <a class="float-right text-primary" href="{{ route('get_movie_index_ad_route') }}" target="_blank">Movie page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($movieList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            {{-- Theater List --}}
            @if(!$theaterList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Theater List</b>
                        <a class="float-right text-primary" href="{{ route('get_theater_index_ad_route') }}" target="_blank">Theater page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($theaterList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Ad List --}}
            @if(!$adList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Ad List</b>
                        <a class="float-right text-primary" href="{{ route('get_ads_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Golf List --}}
            @if(!$golfList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Golf List</b>
                        <a class="float-right text-primary" href="{{ route('get_golf_shop_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($golfList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Golf Image List --}}
            @if(!$golfImageList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Golf Image List</b>
                        <a class="float-right text-primary" href="{{ route('get_golf_shop_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($golfImageList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Personal List --}}
            @if(!$personalFirstImages->isEmpty() || !$personalSecondImages->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Personal List</b>
                        <a class="float-right text-primary" href="{{ route('get_personal_trading_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personalFirstImages as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                                @foreach ($personalSecondImages as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- BullBoard List --}}
            @if(!$bullboardFirstImage->isEmpty() || !$bullboardSecondImage->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>BullBoard List</b>
                        <a class="float-right text-primary" href="{{ route('get_bull_board_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bullboardFirstImage as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                                @foreach ($bullboardSecondImage as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- RealEstate List --}}
            @if(!$realEstateFirstImage->isEmpty() || !$realEstateSecondImage->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>RealEstate List</b>
                        <a class="float-right text-primary" href="{{ route('get_real_estate_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($realEstateFirstImage as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                                @foreach ($realEstateSecondImage as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- User avatar --}}
            @if (!$userAvatar->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>User Avatar</b>
                        <a class="float-right text-primary" href="{{ route('get_user_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userAvatar as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Poste town  --}}
            @if (!$posteTown->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Poste Town</b>
                        <a class="float-right text-primary" href="{{ route('get_poste_town_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posteTown as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- food image town --}}
            @if(!$foodImageTown->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Food Image Town</b>
                        <a class="float-right text-primary" href="{{ route('get_poste_town_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($foodImageTown as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Business  --}}
            @if (!$businessGalleries->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Business</b>
                        <a class="float-right text-primary" href="{{ route('get_business_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessGalleries as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Business map list --}}
            @if (!$businessMapList->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Business Map List</b>
                        <a class="float-right text-primary" href="{{ route('get_business_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessMapList as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Business  --}}
            @if (!$businessListFormPrimaryMap->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Business List Form Primary Map</b>
                        <a class="float-right text-primary" href="{{ route('get_business_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessListFormPrimaryMap as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Business  --}}
            @if (!$businessListFromAvatar->isEmpty())
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <b>Business List Form Avatar</b>
                        <a class="float-right text-primary" href="{{ route('get_business_index_ad_route') }}" target="_blank">Ad page</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessListFromAvatar as $item)
                                <td class="text-center">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @endif
        </div>
    </div>
</div>
@endsection
