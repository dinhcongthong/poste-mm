<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Movie;
use App\Models\Theater;
use App\Models\MovieShowtime;

class CinemaController extends Controller
{
    public function index(Request $request) {
        
        $show_date = date('Y-m-d');
        
        if(!empty($request->show_date)) {
            $show_date = $request->show_date;
        }
        
        $movieList = Movie::with(['getThumbnail', 'getShowtimes'])->whereHas('getShowTimes', function($query) use($show_date) {
            $query->whereDate('show_date', $show_date);
        })->get();
        
        if(!$movieList->isEmpty()) {
            $theaterList = Theater::with(['getThumbnail', 'getChildTheater'])->where('parent_id', 0)->whereHas('getChildTheater', function($query) use($show_date) {
                $query->whereHas('getShowTimes', function($query2) use($show_date) {
                    $query2->whereDate('show_date', $show_date);
                });
            })->get();
            $this->data['theaterList'] = $theaterList;
        }
        
        $this->data['movieList'] = $movieList;
        $this->data['show_date'] = $show_date;
        
        return view('www.pages.cinema.index')->with($this->data);
    }
}
