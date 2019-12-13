<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Config;

use App\Http\Requests\AdRequest;

use App\Models\Ad;
use App\Models\AdPosition;
use App\Models\Gallery;
use App\Models\ImageFactory;
use App\Models\Base;
use App\Models\Customer;
use App\Models\City;
use App\Models\Param;


class AdsController extends Controller
{
    // Ads Function
    public function index() {
        // $adList = Ad::getAdList();

        // $this->data['adList'] = $adList;

        return view('admin.pages.advertisement.index')->with($this->data);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'position',
            3 => 'user',
            4 => 'status',
            5 => 'inform-sale',
            6 => 'updated-at',
            7 => 'action'
        );

        $totalData = Ad::withTrashed()->orderBy('id', 'desc')->get()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $adList = Ad::withTrashed()->with(['getAdPosition', 'getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            // $adList = Ad::withTrashed()->with(['getAdPosition', 'getUser'])->get();
            // $adList = Ad::getAdPosition()->getUser()->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $adList =  Ad::withTrashed()->with(['getAdPosition'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();

            $totalFiltered = Ad::withTrashed()->with(['getAdPosition'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->count();
        }

        $data = array();


        if(!empty($adList)) {
            foreach ($adList as $item) {
                $nestedData['id']  = $item->id;

                if( $item->inform_sale == 1) { 
                    $class_item = 'btn-success';
                    $inform_item = 'Informing';
                } else {
                    $class_item = 'btn-danger';
                    $inform_item = 'Expired';
                }

                if( $item->trashed() ) {
                    $status = '<i class="fas fa-times-circle text-danger"></i>';
                }
                else {
                    $status = '<i class="fas fa-check-circle text-success"></i>';
                }

                $html =                        $item->name;
                $html .='                       <a href="#" class="ml-2" data-toggle="tooltip" data-placement="bottom" title="'.$item->end_date.'">';
                                                    if(date('Y-m-d') > date('Y-m-d', strtotime($item->end_date))) {
                $html .='                               <i class="far fa-calendar-alt text-daner"></i>';
                                                    }else {
                $html .='                               <i class="far fa-calendar-alt text-success"></i>';
                                                    }
                $html .='                       </a>';

                $nestedData['name'] = $html;
                
                $html = $item->getAdPosition->name;
                $nestedData['position'] = $html;

                $html =  getUserName($item->getUser);
                $nestedData['user'] = $html;

                $html ='                       <a class="change-status" href="#" data-id="'.$item->id.'">';
                $html .=                                $status;                          
                $html .='                       </a>';
                $nestedData['status'] = $html;
                
                $html ='                        <button type="button" class="btn-inform btn btn-sm '.$class_item.'" data-id="'.$item->id.'">'.$inform_item.'</button>';
                $nestedData['inform-sale'] = $html;

                $html =                    date_format($item->updated_at, 'Y-m-d H:i:s');
                $nestedData['updated-at'] = $html;

                $html ='                        <a class="mx-1 text-primary" href="'.route('get_ads_edit_ad_route', ['id' => $item->id]).'">';
                $html .='                            <i class="fas fa-edit"></i>';
                $html .='                        </a>';  

                $nestedData['action'] = $html;

                $data[] = $nestedData;
            }
        } //
        $json_data = array(
            'draw'              => intval($request->draw),
            'recordsTotal'      => intval($totalData),
            'recordsFiltered'   => intval($totalFiltered),
            'data'              => $data
        );

        return response()->json($json_data);
        // return 'json';

    }

    public function loadPositionDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'position',
            2 => 'arrangement',
            3 => 'version-show',
            4 => 'user',
            5 => 'updated-at',
            6 => 'action'
        );

        $totalData = AdPosition::withTrashed()->count();

        $totalFiltered = $totalData;

        // $limit = 10;
        // $start = 0;
        // $order = $columns[0];
        // $dir = 'desc';

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $howToShowList = Config::get('ad.how_to_show');
        $versionShowList = Config::get('ad.version_show');

        if(empty($request->input('search.value'))) {
            $positionList = AdPosition::withTrashed()->with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
            // $positionList = AdPosition::withTrashed()->with(['getUser'])->get();
            // $positionList = AdPosition::withTrashed()->with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $positionList =  AdPosition::withTrashed()->with(['getUser'])
            ->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();

            $totalFiltered = AdPosition::withTrashed()->with(['getUser'])
            ->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->count();
        }

        $data = array();


        if(!empty($positionList)) {
            foreach ($positionList as $position) {
                $html = $position->id;
                $nestedData['id']  = $html;

                $html =     $position->name;
                $nestedData['position']  = $html;

                $html =     '<select class="form-control select2-no-search sl-how-to-show" data-id="'.$position->id.'">';
                                foreach($howToShowList as $key => $item) {
                                    if( $position->how_to_show == $key ) {
                $html .=                '<option value="'. $key .'" selected>'.$item.'</option>';                     
                                    } else {
                $html .=                '<option value="'. $key .'">'. $item .'</option>';
                                    }
                                }
                $html .=    '</select>';
                $nestedData['arrangement']  = $html;

                $html =     '<select class="form-control select2-no-search sl-version-show" data-id="'.$position->id.'">';
                                foreach($versionShowList as $key => $item) {
                                    if( $position->version_show == $key ) {
                $html .=                '<option value="'.$key.'" selected>'.$item.'</option>';
                                    } else {
                $html .=                '<option value="'.$key.'">'.$item.'</option>';
                                    }
                                }
                $html .=    '</select>';
                $nestedData['version-show']  = $html;

                $html =     getUserName($position->getUser);
                $nestedData['user']  = $html;
                
                $html =     date_format($position->updated_at, 'Y-m-d H:i:s');
                $nestedData['updated-at']  = $html;

                $html =     '<a class="mx-1" href="'.route('get_ads_position_edit_ad_route', ['id' => $position->id] ).'">
                                <i class="fas fa-edit text-primary"></i>
                            </a>';
                $nestedData['action']  = $html;            

                $data[] = $nestedData;
            }
        } //
        $json_data = array(
            'draw'              => intval($request->draw),
            'recordsTotal'      => intval($totalData),
            'recordsFiltered'   => intval($totalFiltered),
            'data'              => $data
        );

        return response()->json($json_data);
    }

    public function getUpdate($id = 0) {

        $ad = Ad::getItem($id);

        if(!is_null($ad)) {
            $name = $ad->name;
            $description = $ad->description;
            $customerId = $ad->customer_id;
            $positionId = $ad->position_id;
            $cityId = $ad->city_id;
            $utmCampaign = $ad->utm_campaign;
            $imageURL = Base::getUploadURL($ad->getImage->name, $ad->getImage->dir);
            $link = $ad->link;
            $startDate = date('m-d-Y',  strtotime($ad->start_date));
            $endDate = date('m-d-Y', strtotime($ad->end_date));
            $note = $ad->note;
            $status = !$ad->trashed();
        } else {
            $name = '';
            $description = '';
            $customerId = 0;
            $positionId = 0;
            $cityId = 0;
            $utmCampaign = '';
            $imageURL = '';
            $link = '';
            $startDate = date('m-d-Y');
            $endDate = '';
            $note = '';
            $status = 1;
        }

        // Get old value from submit form with validation fail
        if(old('name')) {
            $name = old('name');
        }
        if(old('description')) {
            $description = old('description');
        }
        if(old('customer_id')) {
            $customerId = old('customer_id');
        }
        if(old('position_id')) {
            $positionId = old('position_id');
        }
        if(old('city_id')) {
            $cityId = old('city_id');
        }
        if(old('utm_campaign')) {
            $utmCampaign = old('utm_campaign');
        }
        if(old('link')) {
            $link = old('link');
        }
        if(old('start_date')) {
            $startDate = old('start_date');
        }
        if(old('end_date')) {
            $endDate = old('end_date');
        }
        if(old('note')) {
            $note = old('note');
        }
        if(old('status')) {
            $status = old('status');
        }

        $customerList = Customer::getCustomerList();
        $positionList = AdPosition::getPositionListNonTrashed();
        $cityList = City::getCityList();

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['description'] = $description;
        $this->data['customerId'] = $customerId;
        $this->data['positionId'] = $positionId;
        $this->data['cityId'] = $cityId;
        $this->data['utmCampaign'] = $utmCampaign;
        $this->data['imageURL'] = $imageURL;
        $this->data['link'] = $link;
        $this->data['startDate'] = $startDate;
        $this->data['endDate'] = $endDate;
        $this->data['note'] = $note;
        $this->data['status'] = $status;

        $this->data['customerList'] = $customerList;
        $this->data['positionList'] = $positionList;
        $this->data['cityList'] = $cityList;

        return view('admin.pages.advertisement.update')->with($this->data);
    }

    public function postUpdate(AdRequest $request, $id = 0) {
        $galleryId = 0;
        if($request->hasFile('ip_image')) {
            $file = $request->ip_image;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'advertisement', 'image');
                $galleryId = $gallery_id[0];
            }
        }

        $start_date = date_create_from_format('m-d-Y', $request->start_date);
        $end_date = date_create_from_format('m-d-Y', $request->end_date);

        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'customer_id' => $request->customer_id,
            'position_id' => $request->position_id,
            'image' => $galleryId,
            'link' => $request->link,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'note' => $request->note,
            'utm_campaign' => $request->utm_campaign,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
            'city_id' => $request->city_id,
        );

        $result = Ad::updateAd($data, $id);

        if($result) {
            return redirect()->route('get_ads_index_ad_route');
        }
    }

    public function changeStatus(Request $request) {
        $id = $request->id;

        return Ad::changeStatus($id);
    }

    public function updateInform(Request $request) {
        $id = $request->id;

        return Ad::updateInform($id);
    }

    public function postDelete(Request $request) {
        $id = $request->id;

        $result = Ad::deleteAd($id);

        if($result['result']) {
            $adList = Ad::getAdList();

            $data['adList'] = $adList;

            $view = view('admin.pages.advertisement.index')->with($data)->render();

            $result = array(
                'result' => 1,
                'view' => $view
            );
        }

        return response()->json($result);
    }

    // Ads Position Function
    public function getPosition() {
        // $positionList = AdPosition::getPositionList();
        // $howToShowList = Config::get('ad.how_to_show');
        // $versionShowList = Config::get('ad.version_show');

        // $this->data['positionList'] = $positionList;
        // $this->data['howToShowList'] = $howToShowList;
        // $this->data['versionShowList'] = $versionShowList;
        // return $this->data;
        return view('admin.pages.advertisement.position')->with($this->data);
    }

    public function getAddPosition($id = 0) {
        $position = AdPosition::getPositionItem($id);

        $id = $id;
        $name = '';
        $slug = '';
        $howToShowId = 0;
        $description = '';
        $versionShowId = 0;

        if(!is_null($position)) {
            $id = $position->id;
            $name = $position->name;
            $slug = $position->slug;
            $howToShowId = $position->how_to_show;
            $description = $position->description;
            $versionShowId = $position->version_show;
        }

        $howToShowList = Config::get('ad.how_to_show');
        $versionShowList = Config::get('ad.version_show');

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;
        $this->data['howToShowId'] = $howToShowId;
        $this->data['description'] = $description;
        $this->data['versionShowId'] = $versionShowId;
        $this->data['howToShowList'] = $howToShowList;
        $this->data['versionShowList'] = $versionShowList;

        return view('admin.pages.advertisement.position-add')->with($this->data);
    }

    public function postAddPosition(Request $request, $id = 0) {
        $name = $request->name;
        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');
        $description = $request->description;
        $how_to_show = $request->how_to_show;
        $version_show = $request->version_show;

        $data = array(
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'how_to_show' => $how_to_show,
            'version_show' => $version_show,
            'user_id' => Auth::user()->id
        );

        $result = AdPosition::updatePosition($data, $id);

        if($result) {
            return redirect()->route('get_ads_position_ad_route');
        }
    }

    public function ajaxChangeHowToShow(Request $request) {
        $id = $request->id;
        $howToShowVal = $request->howToShowId;

        return AdPosition::changeHowToShow($id, $howToShowVal);
    }

    public function ajaxChangeVersionShow(Request $request) {
        $id = $request->id;
        $versionShowVal = $request->versionId;

        return AdPosition::changeVersionShow($id, $versionShowVal);
    }
}
