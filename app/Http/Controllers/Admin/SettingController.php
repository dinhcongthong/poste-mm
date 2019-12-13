<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\SettingRequest;

use App\Models\Setting;
use App\Models\Param;

class SettingController extends Controller
{
    public function index() {
        $settingList = Setting::getList();
        
        $this->data['settingList'] = $settingList;
        
        return view('admin.pages.setting.index')->with($this->data);
    }
    
    public function loadTableData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'value',
            3 => 'tag',
            4 => 'user',
            5 => 'last_update',
            6 => 'action'
        );
        
        $totalData = Setting::all()->count();
        
        $totalFiltered = $totalData;
        
        $limit = $request->length;
        $start = $request->start;

        // $limit = $request->length ?? 10;
        // $start = $request->start ?? 0;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        // $order = $columns[0];
        // $dir = 'desc';
        
            // $search = 10;
        // if (!$search) {
        if (empty($request->input('search.value'))) {
            $setting_list = Setting::with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');
            
            $setting_list =  Setting::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('value', 'LIKE', "%{$search}%")
            ->orWhere('updated_at', 'LIKE', "%{$search}%")
            ->orWhere('user_id', 'LIKE', "%{$search}%")
            ->orWhereHas('getUser', function ($query) use ($search) {
                $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('getTag', function ($query) use ($search) {
                $query->where('news_type', 'LIKE', "%{$search}%");
            })
            
            ->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();
            
            $totalFiltered = Setting::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('value', 'LIKE', "%{$search}%")
            ->orWhere('updated_at', 'LIKE', "%{$search}%")
            ->orWhere('user_id', 'LIKE', "%{$search}%")
            ->orWhereHas('getUser', function ($query) use ($search) {
                $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('getTag', function ($query) use ($search) {
                $query->where('news_type', 'LIKE', "%{$search}%");
            })->count();
        }
        
        $data = array();
        
        if (!empty($setting_list)) {
            foreach ($setting_list as $setting) {
                $nestedData['id']  = $setting->id;
                $nestedData['name'] = $setting->name;
                $nestedData['value'] = $setting->value;
                $nestedData['tag'] = $setting->getTag->news_type . '.' . $setting->getTag->tag_type;
                $nestedData['user'] = getUserName($setting->getUser);
                $nestedData['last_update'] = date_format($setting->updated_at, "Y-m-d H:i:s");
                
                $html = '<a class="mx-1" href="' . route('post_setting_edit_ad_route', ['id' => $setting->id]) . '">';
                $html .= '<i class="fas fa-edit"></i>';
                $html .= '</a>';
                $html .= '<a class="mx-1 btn-delete" href="#" data-id="' . $setting->id . '">';
                $html .= '<i class="fas fa-trash"></i>';
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
    
    public function getUpdate($id = 0) {
        $item = Setting::getItem($id);
        
        if(is_null($item)) {
            $name = '';
            $value = '';
            $english_value = '';
            $tag = 0;
        } else {
            $name = $item->name;
            $value = $item->value;
            $english_value = $item->english_value;
            $tag = $item->tag;
        }
        
        $tagList = Param::getExactParamList('', $tag_type = 'setting');
        
        if(old('name')) {
            $name = old('name');
        }
        if(old('value')) {
            $value = old('value');
        }
        if(old('english_value')) {
            $english_value = old('english_value');
        }
        if(old('tag')) {
            $tag = old('tag');
        }
        
        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['value'] = $value;
        $this->data['english_value'] = $english_value;
        $this->data['tag'] = $tag;
        $this->data['tagList'] = $tagList;
        
        return view('admin.pages.setting.update')->with($this->data);
    }
    
    public function postUpdate(SettingRequest $request, $id = 0) {
        $data = array(
            'name' => $request->name,
            'value' => $request->value,
            'english_value' => $request->english_value,
            'tag' => $request->tag,
            'slug' => str_slug($request->value, '-'),
            'user_id' => Auth::user()->id
        );
        
        $result = Setting::postUpdate($id, $data);
        
        if($result) {
            return redirect()->route('get_setting_index_ad_route');
        }
    }
    
    public function postDelete(Request $request) {
        $id = $request->id;
        
        $result = Setting::deleteItem($id);
        
        if($result['result']) {
            $settingList = Setting::getList();
            
            $data['settingList'] = $settingList;
            
            $view = view('admin.pages.setting.table')->with($data)->render();
            
            $result = ['result' => 1, 'view' => $view];
        }
        
        return response()->json($result);
    }
}
