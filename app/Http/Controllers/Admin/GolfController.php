<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests\GolfRequest;

use App\Models\Param;
use App\Models\ImageFactory;
use App\Models\Gallery;
use App\Models\Base;
use App\Models\City;
use App\Models\District;
use App\Models\Golf;
use App\Models\GolfImage;

/**
* Every function have type variable
* @param string $type (golf or golf-shop)
*/

class GolfController extends Controller {
    public function index()
    {
        $golfList = Golf::getGolfStationList($getTrashed = true);
        $this->data['golfList'] = $golfList;

        return view('admin.pages.golf.index')->with($this->data);
    }

    public function loadTableData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user',
            3 => 'updated_at',
            4 => 'status',
            5 => 'action'
        );

        $totalData = Golf::withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $golf_list = Golf::withTrashed()->with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $golf_list =  Golf::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = Golf::withTrashed()->with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->orWhere('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($golf_list)) {
            foreach ($golf_list as $item) {
                $nestedData['id']  = $item->id;

                $html = $item->name;
                if($item->is_draft) {
                    $html .= '<span class="font-italic text-danger"> (Draft) </span>';
                }
                $nestedData['name'] = $html;

                $nestedData['user'] = getUserName($item->getUser);

                $nestedData['updated_at'] = date_format($item->updated_at, "Y-m-d H:i:s");

                $html = '';
                if (!$item->is_draft) {
                    $html .= '<a class="btn-status" href="#" data-id="'. $item->id .'">';
                    if(!$item->trashed()) {
                        $html .= '<i class="fas fa-check-circle text-success"></i>';
                    }
                    else { 
                        $html .= '<i class="fas fa-times-circle text-danger"></i>';
                    } 
                    $html .= '</a>';
                }
                $nestedData['status'] = $html;
                
                $type = $request->type;
                if ($type == 'golf-shop') {
                    $html = '<a class="mx-1 text-primary" href="' . route('get_golf_shop_edit_ad_route', ['id' => $item->id]) .'">';
                }
                else {
                     $html = '<a class="mx-1 text-primary" href="' . route('get_golf_edit_ad_route', ['id' => $item->id]) .'">';
                }
                $html .=    '<i class="fas fa-edit"></i>';
                $html .= '</a>';
                $html .= '<a class="mx-1 btn-delete" href="#" data-type="'. $type .'" data-id="'. $item->id .'">';
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

    public function getUpdate($id = 0) {
        $tagItem = Param::getExactParamItem('golf', 'article');
        if(is_null($tagItem)) {
            $tagItem = Param::createNew(array(
                'news_type' => 'golf',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        }
        $tag = $tagItem->id;

        $article = Golf::getItemWithTag($id, $tag, true);

        if(is_null($article)) {
            $name = '';
            $slug = '';
            $keywords = '';
            $description = '';
            $address = '';
            $districtId = 0;
            $cityId = 0;
            $map = '';
            $phone = '';
            $workTime = '';
            $budget = '';
            $yard = '';
            $website = '';
            $thumbURL = '';
            $caddy = '';
            $rental = '';
            $cart = '';
            $facility = '';
            $shower = '';
            $lesson = '';
            $golfStationNumber = 0;

            $draftArticle = Golf::getNewestDraftItem($tag, Auth::user()->id);

            if(is_null($draftArticle)) {
                $data = array(
                    'name' => $name,
                    'slug' => $slug,
                    'keywords' => $keywords,
                    'description' => $description,
                    'address' => $address,
                    'district_id' => $districtId,
                    'city_id' => $cityId,
                    'map' => $map,
                    'phone' => $phone,
                    'budget' => $budget,
                    'work_time' => $workTime,
                    'yard' => $yard,
                    'rental' => $rental,
                    'website' => $website,
                    'tag' => $tag,
                    'thumb_id' => 0,
                    'caddy' => $caddy,
                    'cart' => $cart,
                    'facility' => $facility,
                    'shower' => $shower,
                    'lesson' => $lesson,
                    'golf_station_number' => $golfStationNumber,
                    'user_id' => Auth::user()->id
                );

                $article = Golf::updateGolfStation($id, $data);
                $id = $article->id;

                $golfImages = [];
            } else {
                return redirect()->route('get_golf_edit_ad_route', ['id' => $draftArticle->id]);
            }
        } else {
            $name = $article->name;
            $slug = $article->slug;
            $keywords = $article->keywords;
            $description = $article->description;
            $address = $article->address;
            $districtId = $article->district_id;
            $cityId = $article->city_id;
            $map = $article->map;
            $phone = $article->phone;
            $budget = $article->budget;
            $workTime = $article->work_time;
            $yard = $article->yard;
            $rental = $article->rental;
            $website = $article->website;
            $tag = $article->tag;
            $thumb = $article->getThumbnail;
            $thumbURL = $thumb ? Base::getUploadURL($thumb->name, $thumb->dir) : '';
            $caddy = $article->caddy;
            $cart = $article->cart;
            $facility = $article->facility;
            $shower = $article->shower;
            $lesson = $article->lesson;
            $golfStationNumber = $article->golf_station_number;

            $golfImages = $article->getImageGolfList;
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('slug')) {
            $slug = old('slug');
        }
        if(old('keywords')) {
            $keywords = old('keywords');
        }
        if(old('description')) {
            $description = old('description');
        }
        if(old('address')) {
            $address = old('address');
        }
        if(old('district_id')) {
            $districtId = old('district_id');
        }
        if(old('city_id')) {
            $cityId = old('city_id');
        }
        if(old('map')) {
            $map = old('map');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('work_time')) {
            $workTime = old('work_time');
        }
        if(old('budget')) {
            $budget = old('budget');
        }
        if(old('yard')) {
            $yard = old('yard');
        }
        if(old('website')) {
            $website = old('website');
        }
        if(old('tag')) {
            $tag = old('tag');
        }
        if(old('thumb_url')) {
            $thumbURL = old('thumb_url');
        }
        if(old('caddy')) {
            $caddy = old('caddy');
        }
        if(old('rental')) {
            $rental = old('rental');
        }
        if(old('cart')) {
            $cart = old('cart');
        }
        if(old('facility')) {
            $facility = old('facility');
        }
        if(old('shower')) {
            $shower = old('shower');
        }
        if(old('lesson')) {
            $lesson = old('lesson');
        }
        if(old('golf_station_number')) {
            $golfStationNumber = old('golf_station_number');
        }

        $cityList = City::getCityList();
        $districtList = District::getDistrictListFromCity($cityId);

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;
        $this->data['keywords'] = $keywords;
        $this->data['description'] = $description;
        $this->data['address'] = $address;
        $this->data['districtId'] = $districtId;
        $this->data['cityId'] = $cityId;
        $this->data['map'] = $map;
        $this->data['phone'] = $phone;
        $this->data['workTime'] = $workTime;
        $this->data['budget'] = $budget;
        $this->data['yard'] = $yard;
        $this->data['tag'] = $tag;
        $this->data['caddy'] = $caddy;
        $this->data['website'] = $website;
        $this->data['tag'] = $tag;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['rental'] = $rental;
        $this->data['cart'] = $cart;
        $this->data['facility'] = $facility;
        $this->data['shower'] = $shower;
        $this->data['lesson'] = $lesson;
        $this->data['golfStationNumber'] = $golfStationNumber;
        $this->data['golfImages'] = $golfImages;

        $this->data['cityList'] = $cityList;
        $this->data['districtList'] = $districtList;

        return view('admin.pages.golf.update')->with($this->data);
    }

    public function postUpdate(GolfRequest $request, $id = 0) {
        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $galleryId = 0;
        if($request->hasFile('image')) {
            $file = $request->image;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'golf', 'image');

                $galleryId = $gallery_id_arr[0];
            }
        }

        $golfTag = Param::getExactParamItem('golf', 'article');

        if(is_null($golfTag)) {
            $golfTag = Param::createNew(array(
                'news_type' => 'golf',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $golfTag = $golfTag;
        }
        $golfTag = $golfTag->id;

        if(is_null($request->district_id)) {
            $districtId = 0;
        }

        $data = array(
            'name' => $request->name,
            'slug' => $slug,
            'keywords' => $request->keywords,
            'description' => $request->description,
            'address' => $request->address,
            'district_id' => $districtId,
            'city_id' => $request->city_id,
            'map' => $request->map,
            'phone' => $request->phone,
            'work_time' => $request->work_time,
            'website' => $request->website,
            'thumb_id' => $galleryId,
            'tag' => $golfTag,
            'budget' => $request->budget,
            'yard' => $request->yard,
            'caddy' => $request->caddy,
            'rental' => $request->rental,
            'cart' => $request->cart,
            'facility' => $request->facility,
            'shower' => $request->shower,
            'lesson' => $request->lesson,
            'golf_station_number' => $request->golf_station_number,
            'status' => $request->status,
            'is_draft' => false,
            'user_id' => Auth::user()->id
        );

        $result = Golf::updateGolfStation($id, $data);

        if($result) {
            return redirect()->route('get_golf_index_ad_route');
        }
    }

    public function postUploadImage(Request $request) {

        $validator = Validator::make($request->all(), [
            'imgFile' => 'image|max:2049|mimes:jpeg,jpg,png|required|dimensions:min_width=300,ratio=4/3'
        ], [
            'imgFile.required' => "Dont have iamge",
            'imgFile.max' => 'Image size is too large',
            'imgFile.mimes' => 'Image file type is wrong',
            'imgFile.image' => 'Selected file is not image',
            'imgFile.dimensions' => 'Ratio or Min width is wrong'
            ]
        );

        if($validator->fails()) {
            return response()->json(['result' => 0, 'validatorErrors' => $validator->errors()->all()]);
        }



        if($request->hasFile('imgFile')) {
            $files = $request->imgFile;
            $id = $request->id;

            if(!is_null($files)) {
                $galleryIds = Gallery::uploadImage(array($files), 'golf', 'image');

                if(count($galleryIds) > 0) {
                    foreach($galleryIds as $galleryId) {
                        GolfImage::addNew(['golf_id' => $id, 'gallery_id' => $galleryId]);
                    }

                    $galleries = Gallery::getGalleryList($id = $galleryIds, '', '', 0, $showGallery = false);

                    $view = view('admin.pages.golf.gallery-view')->with(['galleries' => $galleries])->render();

                    return response()->json(['result' => 1, 'view' => $view]);
                }
                return response()->json(['result' => 0, 'error' => "Can not get the data from Gallery"]);
            }
        } else {
            return response()->json(['result' => 0, 'error' => "Dont't have image file"]);
        }
    }

    public function postDeleteImage(Request $request) {
        $galleryId = $request->galleryId;
        $golfId = $request->golfId;

        $golfImage = GolfImage::getItem($golfId, $galleryId);

        if(!is_null($golfImage)) {
            Gallery::deleteFile($golfImage->gallery_id, true);

            $golfImage->delete();

            return response()->json(['result' => 1]);
        }
        return response()->json(['result' => 0, 'error' => 'Can not find any Image']);
    }

    public function postDelete(Request $request) {
        $id = $request->id;
        $type = $request->type;

        $result = Golf::deleteArticle($id);

        if($result['result']) {
            if($type == 'golf-shop') {
                $golfList = Golf::getGolfShopList($getTrashed = true);
            } else {
                $golfList = Golf::getGolfStationList($getTrashed = true);
            }

            $data['golfList'] = $golfList;
            $data['type'] = $type;

            $view = view('admin.pages.golf.table')->with($data)->render();

            $result = array(
                'result' => 1,
                'view' => $view
            );
        }

        return response()->json($result);
    }

    // Golf shop
    public function golfShopIndex() {
        $golfList = Golf::getGolfShopList($getTrashed = true);

        $this->data['golfList'] = $golfList;

        return view('admin.pages.golf.index')->with($this->data);
    }

    public function getShopUpdate($id = 0) {
        $tagItem = Param::getExactParamItem('golf-shop', 'article');
        if(is_null($tagItem)) {
            $tagItem = Param::createNew(array(
                'news_type' => 'golf-shop',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        }
        $tag = $tagItem->id;

        $article = Golf::getItemWithTag($id, $tag, true);

        if(is_null($article)) {
            $name = '';
            $slug = '';
            $keywords = '';
            $description = '';
            $address = '';
            $districtId = 0;
            $cityId = 0;
            $map = '';
            $phone = '';
            $workTime = '';
            $website = '';
            $thumbURL = '';

            $draftArticle = Golf::getNewestDraftItem($tag, Auth::user()->id);

            if(is_null($draftArticle)) {
                $data = array(
                    'name' => $name,
                    'slug' => $slug,
                    'keywords' => $keywords,
                    'description' => $description,
                    'address' => $address,
                    'district_id' => $districtId,
                    'city_id' => $cityId,
                    'map' => $map,
                    'phone' => $phone,
                    'work_time' => $workTime,
                    'website' => $website,
                    'tag' => $tag,
                    'thumb_id' => 0,
                    'user_id' => Auth::user()->id
                );

                $article = Golf::updateGolfStation($id, $data);
                $id = $article->id;

                $golfImages = [];
            } else {
                return redirect()->route('get_golf_shop_edit_ad_route', ['id' => $draftArticle->id]);
            }
        } else {
            $name = $article->name;
            $slug = $article->slug;
            $keywords = $article->keywords;
            $description = $article->description;
            $address = $article->address;
            $districtId = $article->district_id;
            $cityId = $article->city_id;
            $map = $article->map;
            $phone = $article->phone;
            $workTime = $article->work_time;
            $website = $article->website;
            $tag = $article->tag;
            $thumb = $article->getThumbnail;
            $thumbURL = $thumb ? Base::getUploadURL($thumb->name, $thumb->dir) : '';

            $golfImages = $article->getImageGolfList;
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('slug')) {
            $slug = old('slug');
        }
        if(old('keywords')) {
            $keywords = old('keywords');
        }
        if(old('description')) {
            $description = old('description');
        }
        if(old('address')) {
            $address = old('address');
        }
        if(old('district_id')) {
            $districtId = old('district_id');
        }
        if(old('city_id')) {
            $cityId = old('city_id');
        }
        if(old('map')) {
            $map = old('map');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('work_time')) {
            $workTime = old('work_time');
        }
        if(old('website')) {
            $website = old('website');
        }
        if(old('tag')) {
            $tag = old('tag');
        }
        if(old('thumb_url')) {
            $thumbURL = old('thumb_url');
        }

        $cityList = City::getCityList();
        $districtList = District::getDistrictListFromCity($cityId);

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['slug'] = $slug;
        $this->data['keywords'] = $keywords;
        $this->data['description'] = $description;
        $this->data['address'] = $address;
        $this->data['districtId'] = $districtId;
        $this->data['cityId'] = $cityId;
        $this->data['map'] = $map;
        $this->data['phone'] = $phone;
        $this->data['workTime'] = $workTime;
        $this->data['tag'] = $tag;
        $this->data['website'] = $website;
        $this->data['tag'] = $tag;
        $this->data['thumbURL'] = $thumbURL;
        $this->data['golfImages'] = $golfImages;

        $this->data['cityList'] = $cityList;
        $this->data['districtList'] = $districtList;

        return view('admin.pages.golf.shop-update')->with($this->data);
    }

    public function postShopUpdate(GolfRequest $request, $id = 0) {
        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $galleryId = 0;
        if($request->hasFile('image')) {
            $file = $request->image;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'golf', 'image');
                $galleryId = $gallery_id_arr;
            }
        }

        $golfTag = Param::getExactParamItem('golf-shop', 'article');

        if(is_null($golfTag)) {
            $golfTag = Param::createNew(array(
                'news_type' => 'golf-shop',
                'tag_type' => 'article',
                'user_id' => Auth::user()->id,
                'show_on_gallery' => false
            ));
        } else {
            $golfTag = $golfTag;
        }
        $golfTag = $golfTag->id;

        if(is_null($request->district_id)) {
            $districtId = 0;
        }

        $data = array(
            'name' => $request->name,
            'slug' => $slug,
            'keywords' => $request->keywords,
            'description' => $request->description,
            'address' => $request->address,
            'district_id' => $districtId,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'map' => $request->map,
            'work_time' => $request->work_time,
            'website' => $request->website,
            'thumb_id' => $galleryId,
            'tag' => $golfTag,
            'status' => $request->status,
            'is_draft' => false,
            'user_id' => Auth::user()->id,

            'budget' => null,
            'yard' => null,
            'caddy' => null,
            'rental' => null,
            'cart' => null,
            'facility' => null,
            'shower' => null,
            'lesson' => null
        );

        $result = Golf::updateGolfStation($id, $data);

        if($result) {
            return redirect()->route('get_golf_shop_index_ad_route');
        }
    }

    public function postChangeStatus(Request $request) {
        $id  = $request->id;

        $result = Golf::changeStatus($id);

        return response()->json($result);
    }
}
