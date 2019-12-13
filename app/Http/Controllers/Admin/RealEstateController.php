<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Config;

use App\Models\Ad;
use App\Models\AdPosition;
use App\Models\Gallery;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Customer;
use App\Models\City;
use App\Models\Param;
use App\Models\RealEstate;

class RealEstateController extends Controller
{

    public function index() {
        $realEstateList = RealEstate::getRealEstateList($getTrashed = true);

        $this->data['realEstateList'] = $realEstateList ;

        return view('admin.pages.real-estate.index')->with($this->data);
    }

    public function loadTableData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'author',
            3 => 'created_at',
            4 => 'action'
        );

        $totalData = RealEstate::withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $realEstate_list = RealEstate::withTrashed()->with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $realEstate_list =  RealEstate::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = RealEstate::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->orWhere('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($realEstate_list)) {
            foreach ($realEstate_list as $item) {
                $nestedData['id']  = $item->id;

                $nestedData['name'] = $item->name;

                $nestedData['author'] = getUserName($item->getUser);

                $nestedData['created_at'] = date_format($item->created_at, "Y-m-d H:i:s");

                $html = '<a href="#" class="change-status" data-id="' . $item->id . '">';
                if ($item->trashed()) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                } else {
                    $html .= '<i class="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $html .= '<a class="mx-1 btn-delete" href="#" data-id="' . $item->id . '">';
                $html .=    '<i class="fas fa-trash text-danger"></i>';
                $html .= '</a>';
                $nestedData['action'] = $html;

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

    public function changeStatus(Request $request) {
        $id = $request->id;
        $result = RealEstate::updateStatus($id);
        return $result;
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $result = RealEstate::deleteItem($id);

        if($result['result']) {
            $realEstateList = RealEstate::getRealEstateList($getTrashed = true);

            $view = view('admin.pages.real-estate.table')->with(['realEstateList' => $realEstateList])->render();

            return response()->json(['result' => 1, 'view' => $view]);
        }

        return response()->json($result);
    }
}
