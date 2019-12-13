<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Theater;
use App\Models\Movie;
use App\Models\MovieShowtime;
use App\Models\City;
use App\Models\District;
use App\Models\Base;
use App\Models\ImageFactory;
use App\Models\Gallery;
use App\Models\Param;

use App\Http\Requests\MovieRequest;

class CinemaController extends Controller
{
    // Movie Management
    public function index() {
        $movieList = Movie::getMovieList($getTrashed = true);

        $this->data['movieList'] = $movieList;

        return view('admin.pages.cinema.movie-index')->with($this->data);
    }

    public function getUpdate($id = 0) {
        $movie = Movie::getItem($id, $getTrashed = true);

        if(is_null($movie)) {
            $id = 0;
            $name = '';
            $genres = '';
            $actors = '';
            $trailer = '';
            $publishedDate = '';
            $thumbURL = '';
            $description = '';
        } else {
            $id = $movie->id;
            $name = $movie->name;
            $genres = $movie->genres;
            $trailer = $movie->trailer_youtube_id;
            $actors = $movie->actors;
            $publishedDate = date('m-d-Y', strtotime($movie->published_at));
            $thumb = $movie->getThumbnail;
            $thumbURL = Base::getUploadURL($thumb->name, $thumb->dir);
            $description = $movie->description;
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('genres')) {
            $genres = old('genres');
        }
        if(old('trailer')) {
            $trailer = old('trailer');
        }
        if(old('actors')) {
            $actors = old('actors');
        }
        if(old('published_date')) {
            $publishedDate = old('published_date');
        }
        if(old('description')) {
            $description = old('description');
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['genres'] = $genres;
        $this->data['trailer'] = $trailer;
        $this->data['actors'] = $actors;
        $this->data['publishedDate'] = $publishedDate;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['description'] = $description;

        return view('admin.pages.cinema.movie-update')->with($this->data);
    }

    public function postUpdate($id = 0, MovieRequest $request) {
        $galleryId = 0;
        if($request->hasFile('thumbnail')) {
            $file = $request->thumbnail;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'cinema', 'image');
                $galleryId = $gallery_id_arr[0];
            }
        }

        $publishedDate = date_create_from_format('m-d-Y', $request->published_date);

        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'genres' => $request->genres,
            'trailer_youtube_id' => $request->trailer,
            'actors' => $request->actors,
            'image' => $galleryId,
            'published_at' => $publishedDate->format('Y-m-d'),
            'user_id' => Auth::user()->id
        );

        $result = Movie::updateNew($id, $data);

        if($result) {
            return redirect()->route('get_movie_index_ad_route');
        }
    }

    public function postChangeMovieStatus(Request $request) {
        $id = $request->id;

        return Movie::changeStatus($id, $getTrashed = true);
    }

    public function postDeleteMovie(Request $request) {
        $id = $request->id;

        $result = Movie::deleteMovie($id);

        if($result['result']) {
            $movieList = Movie::getMovieList($getTrashed = true);

            $data['movieList'] = $movieList;

            $view = view('admin.pages.cinema.movie-table')->with($data)->render();

            $result = array(
                'result' => 1,
                'view' => $view
            );
        }
        return response()->json($result);
    }

    // Theater Management
    public function getTheaterList() {
        $theaterList = Theater::getTheaterList($getTrashed = true);

        $this->data['theaterList'] = $theaterList;

        return view('admin.pages.cinema.theater-index')->with($this->data);
    }

    public function getTheaterUpdate($id = 0) {
        $theater = Theater::getItem($id, $getTrashed = true);

        if(is_null($theater)) {
            $positionList = [];

            // Data for Item
            $name = '';
            $thumbURL = '';
            $description = '';
            $districtList = [];
        } else {
            $positionList = $theater->getChildTheater;
            $name = $theater->name;
            $description = $theater->description;
            $thumbURL = $theater->getThumb ? Base::getUploadURL($theater->getThumb->name, $theater->getThumb->dir) : '';
            $districtList = [];
        }

        $cityList = City::getCityList();

        $this->data['id'] = $id;
        $this->data['positionList'] = $positionList;
        $this->data['name'] = $name;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['description'] = $description;
        $this->data['cityList'] = $cityList;
        $this->data['districtList'] = $districtList;

        return view('admin.pages.cinema.theater-update')->with($this->data);
    }

    public function postTheaterUpdate(Request $request, $id = 0) {
        $galleryId = 0;
        if($request->hasFile('thumb')) {
            $file = $request->thumb;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'cinema', 'image');
                $galleryId = $gallery_id_arr[0];
            }
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'thumb_id' => $galleryId,
            'user_id' => Auth::user()->id,
            'address' => NULL,
            'district_id' => 0,
            'city_id' => 0,
            'parent_id' => 0
        ];

        $theater = Theater::updateNew($id, $data);

        $id = $theater->id;


        $positionNameArr = $request->position_name;
        $positionDistrictArr = $request->district_id;
        $positionCityArr = $request->city_id;
        $positionAddressArr = $request->position_address;
        $positionIdArr = $request->position_id;

        if(!is_null($positionNameArr)) {
            $positionNumber = count($positionNameArr);
            for($i = 0; $i < $positionNumber; $i++) {
                $districtId = 0;
                if(!is_null($positionDistrictArr[$i])) {
                    $districtId = $positionDistrictArr[$i];
                }
                $data = [
                    'name' => $positionNameArr[$i],
                    'address' => $positionAddressArr[$i],
                    'city_id' => $positionCityArr[$i],
                    'district_id' => $districtId,
                    'user_id' => Auth::user()->id,
                    'parent_id' => $id,
                    'description' => NULL,
                    'thumb_id' => 0
                ];

                $position = Theater::updateNew($positionIdArr[$i], $data);
            }
        }

        return redirect()->route('get_theater_index_ad_route');
    }

    public function ajaxAddMorePosition(Request $request) {
        $positionNumber = $request->positionNumber;
        $cityList = City::getCityList();

        $data = array(
            'positionNumber' => $positionNumber,
            'cityList' => $cityList
        );

        $view = view('admin.pages.cinema.position-info-form')->with($data)->render();

        return response()->json(['view' => $view]);
    }

    public function postDeletePosition(Request $request) {
        $id = $request->id;

        return Theater::deletePosition($id);
    }

    public function posteDeleteAndGetView(Request $request) {
        $id = $request->id;

        $result = Theater::deletePosition($id);

        if($result['result']) {
            $theaterList = Theater::getTheaterList($getTrashed = true);

            $data['theaterList'] = $theaterList;

            $view = view('admin.pages.cinema.theater-table')->with($data)->render();

            $result = ['result' => 1, 'view' => $view];
        }

        return response()->json($result);
    }

    public function postChangeTheaterStatus(Request $request) {
        $id = $request->id;

        $result = Theater::changeStatus($id);

        return $result;
    }

    /* Show time Management */
    public function getUpdateShowTime() {
        MovieShowtime::clearOutDateShowTime();

        $cityList = City::getCityList();
        $movieList = Movie::getMovieList();

        $this->data['cityList'] = $cityList;
        $this->data['movieList'] = $movieList;

        return view('admin.pages.cinema.showtime')->with($this->data);
    }

    public function postUpdateShowTime($movie_id = 0, Request $request) {
        $movieId = $request->movie_id;
        $cityId = $request->city_id;
        $showtimeIdArr = $request->showtime_ids;
        $positionIdArr = $request->position_ids;
        $dateArr = $request->show_dates;
        $hourArr = $request->show_hours;

        $showtimeCount = count($showtimeIdArr);

        for($i = 0; $i < $showtimeCount; $i++) {
            $showtimeId = $showtimeIdArr[$i];
            $positionId = $positionIdArr[$i];
            $showDate = date_create_from_format('m-d-Y', $dateArr[$i]);
            $showHour = $hourArr[$i];

            $data = [
                'movie_id' => $movieId,
                'position_id' => $positionId,
                'show_date' => $showDate,
                'show_hours' => $showHour,
                'city_id' => $cityId
            ];

            MovieShowTime::updateShowTime($showtimeId, $data);
        }

        return redirect()->route('get_movie_index_ad_route');
    }

    public function getAjaxAddShowTime(Request $request) {
        $showtimeCount = $request->showtime_count;
        $theaterList = Theater::getTheaterList();

        $view = view('admin.pages.cinema.add-showtime-form')->with(['theaterList' => $theaterList, 'showtimeCount' => $showtimeCount])->render();

        return response()->json(['result' => 1, 'view' => $view]);
    }

    public function getAjaxPositionFromBranch(Request $request) {
        $cityId = $request->city_id;
        $branchId = $request->branch_id;

        $positionList = Theater::getPositionFromCityAndBranch($branchId, $cityId);

        $html = '<option value="">Please choose position</option>';

        foreach($positionList as $position) {
            $html .= '<option value="'.$position->id.'">'.$position->name.'</option>';
        }

        return response()->json(['view' => $html]);
    }

    public function getAjaxShowtimeList(Request $request) {
        $movieId = $request->movie_id;
        $cityId = $request->city_id;

        $showtimeList = MovieShowtime::getShowTimeList($movieId, $cityId);
        $theaterList = Theater::getTheaterList();

        $data = [
            'showtimeList' => $showtimeList,
            'theaterList' => $theaterList
        ];

        $view = view('admin.pages.cinema.showtime-list')->with($data)->render();

        return response()->json(['view' => $view]);
    }

    public function postDeleteShowtime(Request $request) {
        $id = $request->id;

        return MovieShowtime::deleteShowtime($id);
    }
}
