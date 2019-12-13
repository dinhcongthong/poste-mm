<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\City;

class CityController extends Controller
{
    public function index() {
        $cityList = City::getCityList($getTrashed = true);

        $this->data['cityList'] = $cityList;

        return view('admin.pages.city.index')->with($this->data);
    }

    public function loadTableData (Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user',
            3 => 'status'
        );

        $totalData = City::all()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $city_list = City::with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $city_list =  City::with('getUser')->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = City::with('getUser')->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($city_list)) {
            foreach ($city_list as $item) {
                $nestedData['id']  = $item->id;
                $nestedData['name'] = $item->name;
                $nestedData['user'] = getUserName($item->getUser);
                
                $html = '<a href="#" class="change-status" data-id="'. $item->id .'">';
                if($item->trashed()) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                }
                else {
                    $html .= '<i class="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            'draw'              => intval($request->draw),
            'recordsTotal'      => intval($totalData),
            'recordsFiltered'   => intval($totalFiltered),
            'data'              => $data
        );

        return response()->json($json_data);
    }

    public function getAdd($id = 0) {
        $cityItem = City::getItem($id, $getTrashed = true);

        if(is_null($cityItem)) {
            $name = '';
            $slug = '';
        } else {
            $name = $cityItem->name;
            $slug = $cityItem->slug;
        }
        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;

        return view('admin.pages.city.update')->with($this->data);
    }

    public function postAdd(Request $request, $id = 0) {
        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $data = array(
            'name' => $request->name,
            'slug' => $slug,
            'user_id' => Auth::user()->id
        );

        $result = City::updateItem($data, $id);

        if($result) {
            return redirect()->route('get_city_index_ad_route');
        }
    }

    public function posteChangeStatus(Request $request) {
        $id = $request->id;
        $result = City::updateStatus($id);
        return $result;
    }

}
