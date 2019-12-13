<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Param;

use App\Http\Requests\ParamRequest;

class ParamController extends Controller
{
    public function index() {
        $paramList = Param::getParamList();

        $this->data['paramList'] = $paramList;

        return view('admin.pages.param.index')->with($this->data);
    }

    public function loadTableData (Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'showOnGallery',
            3 => 'user',
            4 => 'last_update'
        );

        $totalData = Param::all()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $param_list = Param::with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $param_list =  Param::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('news_type', 'LIKE', "%{$search}%")
                ->orWhere('tag_type', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = Param::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('news_type', 'LIKE', "%{$search}%")
                ->orWhere('tag_type', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($param_list)) {
            foreach ($param_list as $item) {
                $nestedData['id']  = $item->id;

                $nestedData['name'] = $item->news_type . '.' . $item->tag_type;

                $html = '<a href="#" class="change-show-gallery" data-id="'. $item->id .'">';
                if(!$item->show_on_gallery) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                }
                else {
                    $html .= '<i class="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $nestedData['showOnGallery'] = $html;

                $nestedData['user'] = getUserName($item->getUser);
                $nestedData['last_update'] = date_format($item->updated_at, "Y-m-d H:i:s");
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

    public function getAdd() {
        $newsTypeList = Param::getNewsTypeList();
        $tagTypeList = Param::getTagTypeList();

        $this->data['newsTypeList'] = $newsTypeList;
        $this->data['tagTypeList'] = $tagTypeList;

        if(old('ip_news_type')) {
            $ipNewsType = old('ip_news_type');
        } else {
            $ipNewsType = '';
        }
        if(old('sl_news_type')) {
            $slNewsType = old('sl_news_type');
        } else {
            $slNewsType = '';
        }
        if(old('ip_tag_type')) {
            $ipTagType = old('ip_tag_type');
        } else {
            $ipTagType = '';
        }
        if(old('sl_tag_type')) {
            $slTagType = old('sl_tag_type');
        } else {
            $slTagType = '';
        }

        $this->data['ipNewsType'] = $ipNewsType;
        $this->data['slNewsType'] = $slNewsType;
        $this->data['ipTagType'] = $ipTagType;
        $this->data['slTagType'] = $slTagType;

        return view('admin.pages.param.update')->with($this->data);
    }

    public function postAdd(ParamRequest $request) {
        $newsType = $request->ip_news_type;
        if(empty($newsType)) {
            $newsType = $request->sl_news_type;
        }

        $tagType = $request->ip_tag_type;
        if(empty($tagType)) {
            $tagType = $request->sl_tag_type;
        }

        $data = [
            'news_type' => strtolower($newsType),
            'tag_type' => strtolower($tagType),
            'user_id' => Auth::user()->id
        ];

        $result = Param::createNew($data);

        if($result) {
            return redirect()->route('get_param_index_ad_route');
        }
    }

    public function changeShowOnGallery(Request $request) {
        $id = $request->id;

        return Param::changeShowOnGallery($id);
    }
}
