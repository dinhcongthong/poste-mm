<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Ad;
use App\Models\AdPosition;
use App\Models\Gallery;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Customer;
use App\Models\City;
use App\Models\Param;
use App\Models\PersonalTrading;


class PersonalTradingController extends Controller
{
    public function index() {
        $personalTradingList = PersonalTrading::getPersonalTradingList($getTrashed = true);

        $this->data['personalTradingList'] = $personalTradingList;
        return view('admin.pages.personal-trading.index')->with($this->data);
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

        $totalData = PersonalTrading::withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $personalTrading_list = PersonalTrading::withTrashed()->with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $personalTrading_list =  PersonalTrading::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = PersonalTrading::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('created_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->orWhere('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($personalTrading_list)) {
            foreach ($personalTrading_list as $item) {
                $nestedData['id']  = $item->id;

                $nestedData['name'] = $item->name;

                $nestedData['created_at'] = date_format($item->created_at, 'Y-m-d H:i:s');

                $nestedData['author'] = getUserName($item->getUser);

                $html = '<a href="#" class="change-status" data-id="' . $item->id . '">';
                if ($item->trashed()) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                } else {
                    $html .= '<i class="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $html .= '<a class="mx-1 btn-delete" href="#" data-id="'. $item->id .'">';
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

        $result = PersonalTrading::updateStatus($id);

        return $result;
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $result = PersonalTrading::deleteItem($id);

        if($result['result']) {
            $personalTradingList = PersonalTrading::getPersonalTradingList($getTrashed = true);

            $view = view('admin.pages.personal-trading.table')->with(['personalTradingList' => $personalTradingList])->render();

            return response()->json(['result' => 1, 'view' => $view]);
        }

        return response()->json($result);
    }
}
