<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\District;
use App\Models\City;

class DistrictController extends Controller
{
    public function index() {
        $districtList = District::getDistrict($getTrashed = true);

        $this->data['districtList'] = $districtList;

        return view('admin.pages.district.index')->with($this->data);
    }

    public function getAdd($id = 0) {
        $districtItem = District::getItem($id, $getTrashed = true);
        $cityList = City::getCityList();

        if(is_null($districtItem)) {
            $name = '';
            $slug = '';
            $cityId = 0;
        } else {
            $name = $districtItem->name;
            $slug = $districtItem->slug;
            $cityId = $districtItem->city_id;
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;
        $this->data['cityId'] = $cityId;
        $this->data['cityList'] = $cityList;

        return view('admin.pages.district.update')->with($this->data);
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
            'city_id' => $request->city_id,
            'user_id' => Auth::user()->id
        );

        $result = District::updateItem($data, $id);

        if($result) {
            return redirect()->route('get_district_index_ad_route');
        }
    }

    public function getDistrictFromCity($city_id) {
        $districtList = District::getDistrictListFromCity($city_id);

        $html = '<option value="">Please choose District</option>';

        foreach($districtList as $district) {
            $html .= '<option value="'.$district->id.'">'.$district->name.'</option>';
        }

        return response()->json(['result' => 1, 'view' => $html]);
    }

    public function posteChangeStatus(Request $request) {
        $id = $request->id;
        $result = District::updateStatus($id);
        return $result;
    }
}
