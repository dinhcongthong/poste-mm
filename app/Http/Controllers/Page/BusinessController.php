<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Business\BusinessRequest;
use App\Http\Requests\Business\BusinessGalleryRequest;
use App\Http\Requests\Business\BusinessPDFRequest;
use App\Http\Requests\Business\BusinessServiceRequest;
use App\Http\Requests\Business\BusinessMapRequest;
use App\Http\Requests\Business\BusinessRelatedRequest;

use App\Mail\Feedback\OwnerMail as FeedbackOwnerMail;
use App\Mail\Feedback\UserMail as FeedbackUserMail;

use Validator;
use Config;
use File;

use App\Models\Category;
use App\Models\Business;
use App\Models\BusinessGallery;
use App\Models\BusinessService;
use App\Models\BusinessRelate;
use App\Models\BusinessMap;
use App\Models\CategoryBusiness;
use App\Models\Base;
use App\Models\Gallery;
use App\Models\ImageFactory;
use App\Models\Param;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\PosteNotification;

use App\Models\SavedLink;

class BusinessController extends Controller
{
    public function index() {

        $premium_list = Business::with(['getThumb', 'getCity', 'getCategories'])->where(function($q) {
            $q->whereDate('end_free_date', '>=', date('Y-m-d'))->orWhere(function($que) {
                $que->where('fee', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
            });
        })->inRandomOrder()->get();
        $normal_list = Business::with(['getThumb', 'getCity', 'getCategories'])->whereNotIn('id', $premium_list->pluck('id')->toArray())->inRandomOrder()->get();
        $business_list = $premium_list->merge($normal_list)->paginate(12);

        $this->data['business_list'] = $business_list;

        $this->loadPageInfoFromChild('business', 'category', 0);
        return view('www.pages.business.index')->with($this->data);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $category_id = substr($category, $key + 1);

        $smallest_date = date('Y-m-d', strtotime('-30 days'));

        $category = Category::with(['getChildrenCategory', 'getParentCategory'])->find($category_id);

        if(is_null($category)) {
            $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            return view('errors.404')->with($this->data);
        }

        if($category->slug != $slug) {
            return redirect()->route('get_business_category_route', $category->slug.'-'.$category->id);
        }

        if(!is_null($category->getParentCategory)){
            $parent_category = $category->getParentCategory;
            $category_ids = [$category_id];
        } else {
            $parent_category = $category;
            $category_ids = $parent_category->getChildrenCategory->pluck('id')->toArray();
        }

        $premium_list = Business::with(['getThumb', 'getCity', 'getCategories'])->whereHas('getBusinessCategoryList', function ($query) use ($category_ids) {
            $query->whereIn('category_id', $category_ids);
        })->where(function($q) {
            $q->whereDate('end_free_date', '>=', date('Y-m-d'))->orWhere(function($que) {
                $que->where('fee', 1)->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'));
            });
        })->inRandomOrder()->get();
        $normal_list = Business::with(['getThumb', 'getCity', 'getCategories'])->whereHas('getBusinessCategoryList', function ($query) use ($category_ids) {
            $query->whereIn('category_id', $category_ids);
        })->whereNotIn('id', $premium_list->pluck('id')->toArray())->inRandomOrder()->get();

        $business_list = $premium_list->merge($normal_list)->paginate(12);

        $this->data['business_list'] = $business_list;
        $this->data['parent_category'] = $parent_category;

        $this->loadPageInfoFromChild('business', 'category', $category_id);

        return view('www.pages.business.index')->with($this->data);
    }

    public function detail($detail) {
        // Set to check and set data for body tag
        $this->data['scrollspy'] = 1;

        $key = strrpos($detail, '-');
        $slug = substr($detail, 0, $key);
        $business_id = substr($detail, $key + 1);

        $business_item = Business::with(['getCategories', 'getBusinessCategoryList', 'getThumb', 'getServiceList', 'getMapList.getImage', 'getImageRouteGuide', 'getBusinessRelateList'])->find($business_id);

        $business_galleries = BusinessGallery::with([ 'getImage'])->where('business_id', $business_id)->paginate(18);


        if (is_null($business_item)) {
            $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            return view('errors.404')->with($this->data);
        }
        if($business_item->slug != $slug) {
            return redirect()->route('get_business_detail_route', $business_item->slug.'-'.$business_item->id);
        }

        $this->data['business_item'] = $business_item;
        $this->data['business_galleries'] = $business_galleries;

        $this->loadPageInfoFromChild('business', '', $business_item);

        // -----------------------------------
        // Check Save Link
        $liked = 0;
        if(Auth::check()){
            $user_id = Auth::user()->id;

            $post_type = 'business';

            $saved_item = SavedLink::where('user_id', $user_id)->where('post_id', $business_id)->where('post_type', $post_type)->first();

            if(!is_null($saved_item)) {
                $liked = 1;
            }
        }

        $this->data['liked'] = $liked;

        return view('www.pages.business.detail.detail')->with($this->data);
    }

    public function getUpdate($business = 0) {

        $business_arr   = explode('-', $business);
        $business_id    = end($business_arr);

        $business_item  = Business::with(['getBusinessCategoryList', 'getThumb', 'getBusinessGallery.getImage', 'getServiceList', 'getMapList.getImage', 'getBusinessRelateList'])->withTrashed()->find($business_id);

        if(is_null($business_item)) {
            if($business != 0) {
                $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
                return view('errors.404')->with($this->data);
            }

            $category_ids       = [];
            $thumb_url          = '';
            $description        = '';
            $name               = '';
            $founding_date      = '';
            $representator      = '';
            $employee_number    = '';
            $outline            = '';
            $customer_object    = '';
            $partner            = '';
            $capital            = '';
            $phone              = '';
            $repre_phone        = '';
            $address            = '';
            $website            = '';
            $email              = '';
            $slug               = '';
            $public_address     = 1;
            $public_phone       = 1;
            $public_email       = 1;
            $pdf_url            = '';
            $map                    = '';
            $img_route_guide_url    = '';
            $route_guide            = '';

            $gallery_list       = [];
            $service_list       = [];
            $map_list           = [];
            $relate_list        = [];


            $this->data['pageTitle'] = 'ADD NEW BUSINESS ARTICLE';
        } else {
            if(Auth::user()->id != $business_item->owner_id && Auth::user()->type_id != \App\Models\User::TYPE_ADMIN) {
                $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
                return view('errors.404')->with($this->data);
            }
            $this->data['pageTitle'] = 'EDIT BUSINESS ARTICLE';

            if(!is_null($business_item->getThumb)) {
                $thumb_url = Base::getUploadURL($business_item->getThumb->name, $business_item->getThumb->dir);
            } else {
                $thumb_url = '';
            }

            $category_ids           = $business_item->getBusinessCategoryList->pluck('category_id')->toArray();
            $name                   = $business_item->name;
            $description            = $business_item->description;
            $founding_date          = $business_item->founding_date;
            $representator          = $business_item->representator;
            $employee_number        = $business_item->employee_number;
            $outline                = $business_item->outline;
            $customer_object        = $business_item->customer_object;
            $partner                = $business_item->partner;
            $capital                = $business_item->capital;
            $phone                  = $business_item->phone;
            $repre_phone            = $business_item->repre_phone;
            $address                = $business_item->address;
            $website                = $business_item->website;
            $email                  = $business_item->email;
            $slug                   = $business_item->slug.'-'.$business_item->id;
            $public_address         = $business_item->public_address;
            $public_email           = $business_item->public_email;
            $public_phone           = $business_item->public_phone;
            $map                    = $business_item->map;
            $route_guide            = $business_item->route_guide;

            if(!empty($business_item->pdf_url)) {
                $dir    = '';
                $info   = explode('/', $business_item->pdf_url);
                if(count($info) > 1) {
                    $dir    = $info[0];
                    $pdf_name   = $info[1];
                } else {
                    $pdf_name   = $info[0];
                }
                $pdf_url    = Base::getUploadURL($pdf_name, $dir);
            } else {
                $pdf_url    = '';
            }

            if(!empty($business_item->img_route_guide)) {
                $img_route_guide_url        = Base::getUploadURL($business_item->getImageRouteGuide->name, $business_item->getImageRouteGuide->dir);
            } else {
                $img_route_guide_url        = '';
            }

            $gallery_list   = $business_item->getBusinessGallery;
            $service_list   = $business_item->getServiceList;
            $map_list       = $business_item->getMapList;
            $relate_list    = $business_item->getBusinessRelateList;
        }

        $this->data['category_ids']         = $category_ids;
        $this->data['thumb_url']            = $thumb_url;
        $this->data['name']                 = $name;
        $this->data['description']          = $description;
        $this->data['founding_date']        = $founding_date;
        $this->data['representator']        = $representator;
        $this->data['employee_number']      = $employee_number;
        $this->data['outline']              = $outline;
        $this->data['customer_object']      = $customer_object;
        $this->data['partner']              = $partner;
        $this->data['capital']              = $capital;
        $this->data['phone']                = $phone;
        $this->data['repre_phone']          = $repre_phone;
        $this->data['address']              = $address;
        $this->data['website']              = $website;
        $this->data['email']                = $email;
        $this->data['slug']                 = $slug;
        $this->data['public_address']       = $public_address;
        $this->data['public_email']         = $public_email;
        $this->data['public_phone']         = $public_phone;
        $this->data['pdf_url']              = $pdf_url;
        $this->data['map']                  = $map;
        $this->data['img_route_guide_url']      = $img_route_guide_url;
        $this->data['route_guide']          = $route_guide;

        $this->data['business_id']          = $business_id;
        $this->data['gallery_list']         = $gallery_list;
        $this->data['service_list']         = $service_list;
        $this->data['map_list']             = $map_list;
        $this->data['relate_list']         = $relate_list;



        return view('www.pages.business.update.update')->with($this->data);
    }

    public function postUpdate(BusinessRequest $request) {
        $business_id = $request->business_id;

        $business_item = Business::with(['getBusinessCategoryList', 'getBusinessGallery.getImage'])->withTrashed()->find($business_id);

        $galleryId = 0;
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;

            if (!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'business', 'image');
                $galleryId = $gallery_id_arr[0];
            }
        }
        if(!is_null($request->founding_date)) {
            $founding_date = date('Y-m-d', strtotime($request->founding_date));
        } else {
            $founding_date = null;
        }
        if(is_null($request->public_address)) {
            $public_address = 1;
        } else {
            $public_address = 0;
        }
        if(is_null($request->public_email)) {
            $public_email = 1;
        } else {
            $public_email = 0;
        }
        if(is_null($request->public_phone)) {
            $public_phone = 1;
        } else {
            $public_phone = 0;
        }
        if(!empty($request->pdf_url)) {
            $pdf_info = Base::getUploadFilename($request->pdf_url);
            $pdf_url = $pdf_info['dir'].'/'.$pdf_info['filename'];
        } else {
            $pdf_url = '';
        }

        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'slug' => str_slug($request->name, '-'),
            'thumb_id' => $galleryId,
            'founding_date' => $founding_date,
            'representator' => $request->representator,
            'employee_number' => $request->employee_number,
            'outline' => $request->outline,
            'customer_object' => $request->customer_object,
            'partner' => $request->partner,
            'capital' => $request->capital,
            'phone' => $request->phone,
            'repre_phone' => $request->repre_phone,
            'website' => $request->website,
            'email' => $request->email,
            'user_id' => Auth::user()->id,
            'public_address' => $public_address,
            'public_email' => $public_email,
            'public_phone' => $public_phone,
            'pdf_url' => $pdf_url
        );

        if(is_null($business_item)) {
            if($business_id != 0) {
                $this->data['pageTitle'] = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
                return view('errors.404')->with($this->data);
            }

            $data['end_free_date'] = date('Y-m-d', strtotime('+30 days'));
            $data['owner_id'] = Auth::user()->id;

            $business_item = Business::create($data);
        } else {
            if($galleryId != 0 && $business_item->thumb_id != $galleryId) {
                $data['thumb_id'] = $galleryId;
            } else {
                if($galleryId == 0 && $business_item->thumb_id != 0){
                    $data['thumb_id'] = $business_item->thumb_id;
                } else {
                    $data['thumb_id'] = 0;
                }
            }

            if(!empty($business_item->pdf_url) && $pdf_url != $business_item->pdf_url) {
                $this->deletePDF($business_item->pdf_url);
            }

            $business_item->update($data);
        }

        $category_ids = $request->category_ids;

        $category_item_list = $business_item->getBusinessCategoryList;

        foreach($category_item_list as $item) {
            // return $item;
            if(!in_array($item->category_id, $category_ids)) {
                $item->delete();
            } else {
                if(($key = array_search($item->category_id, $category_ids)) !== false) {
                    unset($category_ids[$key]);
                }
            }
        }

        foreach($category_ids as $item) {
            CategoryBusiness::create(array(
                'business_id' => $business_item->id,
                'category_id' => $item
            ));
        }

        $business_item_gallery_list = $business_item->getBusinessGallery;
        if(!empty($request->gallery_ids)) {
            $gallery_ids = explode(',', $request->gallery_ids);
        } else {
            $gallery_ids = [];
        }

        foreach($business_item_gallery_list as $item) {
            if(!in_array($item->id, $gallery_ids)) {
                $result = Gallery::clearGallery($item->gallery_id, 'business-gallery', $item->id);
                $item->delete();
            }
        }

        if(!empty($gallery_ids)) {
            foreach ($gallery_ids as $gallery_id) {
                $data = array(
                    'business_id' => $business_item->id
                );

                $gallery_item = BusinessGallery::find($gallery_id);
                if(!is_null($gallery_item)) {
                    $gallery_item->update($data);
                } else {
                    $gallery_item = BusinessGallery::create($data);
                }
            }
        }

        return response()->json([
            'result' => 1,
            'business_id' => $business_item->id
            ]);
        }

        public function postSaveService(BusinessServiceRequest $request) {
            $service_id = $request->service_id;
            $service_name = $request->service_name;
            $service_description = $request->service_description;
            $business_id = $request->business_id;

            $result = false;

            if(!empty($service_name)) {
                $data = array(
                    'name' => $service_name,
                    'description' => $service_description,
                    'business_id' => $request->business_id
                );

                $service_item = BusinessService::find($service_id);

                if(is_null($service_item)) {
                    $result = BusinessService::create($data);
                    $id = $result->id;
                } else {
                    $result = $service_item->update($data);
                    $id = $service_item->id;
                }
            }
            if($result) {
                return response()->json([
                    'result' => 1,
                    'id' => $id
                    ]);
                }

                return response()->json([
                    'result' => 0,
                    'error' => 'Have Error When Update Service Info'
                    ]);
                }

                public function postSaveRelated(BusinessRelatedRequest $request) {
                    $related_id     = $request->related_id;
                    $business_id    = $request->business_id;

                    $data = array(
                        'name'           => $request->related_name,
                        'address'        => $request->related_address,
                        'phone'          => $request->related_phone,
                        'website'        => $request->related_website,
                        'business_id'    => $business_id,
                        'email'          => $request->related_email
                    );

                    $relate_item = BusinessRelate::find($related_id);

                    if(is_null($relate_item)) {
                        $result = BusinessRelate::create($data);
                        $relate_id = $result->id;
                    } else {
                        $result = $relate_item->update($data);
                        $relate_id = $relate_item->id;
                    }

                    if($result) {
                        return response()->json([
                            'result'    => 1,
                            'id'        => $relate_id
                            ]);
                        }

                        return response()->json([
                            'result' => 0,
                            'error' => 'Have errors in processing related Business Saving'
                            ]);
                        }

                        public function postSavePrimaryAddress(BusinessMapRequest $request) {
                            $business_id = $request->business_id;

                            $gallery_id = 0;

                            if ($request->hasFile('image_route_guide')) {
                                $file = $request->image_route_guide;

                                if (!is_null($file)) {
                                    $gallery_id_arr = Gallery::uploadImage(array($file), 'business', 'image');
                                    $gallery_id = $gallery_id_arr[0];
                                }
                            }

                            // get and validate Google Map Iframe URL value
                            $map = '';
                            if(!empty($request->map)) {
                                $srcList = [];

                                $regex = '/<iframe.*?\s+src=(?:\'|\")([^\'\">]+)(?:\'|\")/';

                                preg_match_all($regex, $request->map, $srcList);
                                if(!empty($srcList[1][0])) {
                                    $map = $srcList[1][0];
                                }
                            }


                            $data = array(
                                'address'           => $request->address,
                                'map'               => $map,
                                'img_route_guide'   => $gallery_id,
                                'route_guide'       => $request->route_guide
                            );

                            $business_item = Business::withTrashed()->find($business_id);

                            $result = false;
                            if(!is_null($business_item)) {
                                if($data['img_route_guide'] != 0 && $business_item->img_route_guide != $data['img_route_guide']) {
                                    if($business_item->img_route_guide != 0) {
                                        Gallery::clearGallery($business_item->img_route_guide, 'business-img-primary-map', $business_item->id);
                                    }
                                } else {
                                    unset($data['img_route_guide']);
                                }

                                if(!empty($request->map)) {
                                    if(empty($data['map']) || $data['map'] == $business_item->map) {
                                        unset($data['map']);
                                    }
                                }

                                $result = $business_item->update($data);
                            }

                            if(!$result) {
                                return response()->json([
                                    'result' => 0,
                                    'error' => 'Have error when to save Primary Address'
                                    ]);
                                }

                                return response()->json([
                                    'result' => 1,
                                    ]);
                                }

                                public function postSaveMoreMap(BusinessMapRequest $request) {
                                    $branch_id = $request->branch_id;

                                    $gallery_id = 0;

                                    if ($request->hasFile('image_route_guide')) {
                                        $file = $request->image_route_guide;

                                        if (!is_null($file)) {
                                            $gallery_id_arr = Gallery::uploadImage(array($file), 'business', 'image');
                                            $gallery_id = $gallery_id_arr[0];
                                        }
                                    }

                                    $map = '';
                                    if(!empty($request->map)) {
                                        $srcList = [];

                                        $regex = '/<iframe.*?\s+src=(?:\'|\")([^\'\">]+)(?:\'|\")/';

                                        preg_match_all($regex, $request->map, $srcList);

                                        if(!empty($srcList[1][0])) {
                                            $map = $srcList[1][0];
                                        }
                                    }

                                    $data = array(
                                        'address'           => $request->address,
                                        'map'               => $map,
                                        'route_guide'       => $request->route_guide,
                                        'image_route_guide' => $gallery_id,
                                        'business_id'       => $request->business_id
                                    );

                                    $map = BusinessMap::find($branch_id);

                                    if(is_null($map)) {
                                        $result = BusinessMap::create($data);
                                        $id = $result->id;
                                    } else {
                                        if($data['image_route_guide'] != 0 && $map->image_route_guide != $data['image_route_guide']) {
                                            if($map->image_route_guide != 0) {
                                                Gallery::clearGallery($map->image_route_guide, 'business-img-map', $map->id);
                                            }
                                        } else {
                                            unset($data['image_route_guide']);
                                        }

                                        if(!empty($request->map)) {
                                            if(empty($data['map']) || $data['map'] == $map->map) {
                                                unset($data['map']);
                                            }
                                        }

                                        $result = $map->update($data);
                                        $id = $map->id;
                                    }

                                    if(!$result) {
                                        return response()->json([
                                            'result' => 0,
                                            'error' => 'Have error when to save Primary Address'
                                            ]);
                                        }

                                        return response()->json([
                                            'result' => 1,
                                            'id'        => $id
                                            ]);
                                        }

                                        public function postUploadGallery(BusinessGalleryRequest $request) {
                                            if($request->hasFile('image_file')) {
                                                $file = $request->image_file;

                                                $gallery_id_arr = Gallery::uploadImage(array($file), 'bussiness', 'gallery');
                                                $galleryId = 0;
                                                if(count($gallery_id_arr) > 0) {
                                                    $galleryId = $gallery_id_arr[0];
                                                }

                                                if($galleryId != 0) {
                                                    $data = array(
                                                        'gallery_id' => $galleryId
                                                    );

                                                    $result = BusinessGallery::create($data);

                                                    if($result) {
                                                        return response()->json([
                                                            'result' => 1,
                                                            'gallery_id' => $result->id,
                                                            'gallery_url' => $file_url
                                                            ]);
                                                        }

                                                        Gallery::deleteFile($galleryId, true);
                                                    }
                                                }

                                                return response()->json(array(
                                                    'result' => 0,
                                                    'error' => 'Have error in uploading image...'
                                                ));
                                            }

                                            public function postUploadPDFFile(BusinessPDFRequest $request) {
                                                if($request->hasFile('file')) {
                                                    $file = $request->file;
                                                    $dir = 'business_pdf';
                                                    $url = '';

                                                    // Generate random dir
                                                    $dir = trim($dir, '/');
                                                    $filename = $dir.'_'.date('Ymd').'-'.microtime(true).'.'.strtolower($file->getClientOriginalExtension());

                                                    // Get file info and try to move
                                                    $destination = public_path().'/upload/'.$dir.'/';
                                                    $path = $dir.'/'.$filename;
                                                    $uploaded = $file->move($destination, $filename);


                                                    if ($uploaded) {
                                                        $url = asset('upload/'.$path);

                                                        return $data = array(
                                                            'result' => 1,
                                                            'url' => $url
                                                        );
                                                    }
                                                }

                                                return response()->json(array(
                                                    'result' => 0,
                                                    'error' => 'Have error in uploading PDF File...'
                                                ));
                                            }

                                            public function postDeleteMap(Request $request) {
                                                $id = $request->id;

                                                $map_item = BusinessMap::find($id);

                                                $result = true;

                                                if(!is_null($map_item)) {
                                                    if($map_item->image_route_guide != 0) {
                                                        Gallery::clearGallery($map_item->image_route_guide, 'business-img-map', $map_item->id);
                                                    }
                                                    $result = $map_item->delete();
                                                }

                                                if($result) {
                                                    return response()->json([
                                                        'result' => 1
                                                        ]);
                                                    }

                                                    return response()->json([
                                                        'result' => 0,
                                                        'error' => 'Have Error When Delete Map'
                                                        ]);
                                                    }

                                                    public function posteDeleteRelate(Request $request) {
                                                        $id = $request->id;
                                                        $result = true;

                                                        $item = BusinessRelate::find($id);
                                                        if(!is_null($item)) {
                                                            $result = $item->delete();
                                                        }

                                                        if($result) {
                                                            return response()->json([
                                                                'result' => 1
                                                                ]);
                                                            }

                                                            return response()->json([
                                                                'result' => 0,
                                                                'error' => 'Have error in deleting Related Business'
                                                                ]);
                                                            }

                                                            public function postDeletePDF(Request $request) {
                                                                $pdf_info = Base::getUploadFilename($request->pdf_url);

                                                                $path = Config::get('image.upload_path').trim($pdf_info['dir']).'/'.trim($pdf_info['filename']);
                                                                $result = true;
                                                                if(File::exists($path)) {
                                                                    // File exists
                                                                    $result = File::delete($path);
                                                                }

                                                                return response()->json([
                                                                    'result' => $result
                                                                    ]);
                                                                }

                                                                public function deletePDF($pdf_url) {
                                                                    $pdf_info = Base::getUploadFilename($pdf_url);

                                                                    $path = Config::get('image.upload_path').trim($pdf_info['dir']).'/'.trim($pdf_info['filename']);
                                                                    if(File::exists($path)) {
                                                                        // File exists
                                                                        $result = File::delete($path);
                                                                    }
                                                                }

                                                                public function postDeleteService(Request $request) {
                                                                    $id = $request->id;

                                                                    $service_item = BusinessService::find($id);

                                                                    $result = false;

                                                                    if(!is_null($service_item)) {
                                                                        $result = $service_item->delete();
                                                                    }

                                                                    return response()->json([
                                                                        'result' => $result
                                                                        ]);
                                                                    }

                                                                    public function postSaveFeedback (FeedbackRequest $request) {
                                                                        $business_item = Business::find($request->post_id);

                                                                        $result = false;

                                                                        if(!is_null($business_item)) {
                                                                            $owner_id = $business_item->owner_id;
                                                                            if(!is_null($business_item->getOwner)) {
                                                                                $owner_email = $business_item->getOwner->email;
                                                                            } else {
                                                                                $owner_email = $business_item->getUser->email;
                                                                            }
                                                                            $user_name = $request->name;
                                                                            $post_id = $request->post_id;
                                                                            $post_type = 'business';
                                                                            $content = $request->content;
                                                                            $user_subject = $request->subject;
                                                                            $user_email = $request->email;

                                                                            $url = route('get_business_detail_route', $business_item->slug.'-'.$business_item->id);

                                                                            $subject = '[Poste Myanmar] Poste Business Feedback...';
                                                                            Mail::to($user_email)
                                                                            ->send(new FeedbackUserMail($subject, $business_item->name, $url, $content));

                                                                            if(!Mail::failures()) {
                                                                                $data = array(
                                                                                    'email' => $user_email,
                                                                                    'owner_id' => $owner_id,
                                                                                    'post_id' => $post_id,
                                                                                    'content' => $content,
                                                                                    'post_type' => $post_type,
                                                                                    'name' => $user_name,
                                                                                    'type_id' => PosteNotification::TYPE_FEEDBACK
                                                                                );

                                                                                $feedback_item = PosteNotification::create($data);

                                                                                if($feedback_item) {
                                                                                    $subject = '[Poste Myanmar] '.$user_subject;

                                                                                    Mail::to($owner_email)
                                                                                    ->bcc('marketing-mm@poste-vn.com')
                                                                                    // ->bcc('thong@poste-vn.com')
                                                                                    ->send(new FeedbackOwnerMail($subject, $url, $user_email, $content));

                                                                                    $result = true;
                                                                                }
                                                                            }
                                                                        }

                                                                        if($result) {
                                                                            return response()->json([
                                                                                'result' => 1
                                                                                ]);
                                                                            }

                                                                            return response()->json([
                                                                                'result' => 0
                                                                                ]);
                                                                            }

                                                                            public function loadMoreImages (Request $request) {
                                                                                $business_galleries = BusinessGallery::with(['getImage'])->where('business_id', $request->id)->paginate(18);

                                                                                if ($business_galleries->isEmpty()) {
                                                                                    return response()->json([
                                                                                        'result' => 0,
                                                                                        'error' => 'No more data to load'
                                                                                        ]);
                                                                                    }

                                                                                    $html = '';

                                                                                    foreach ($business_galleries as $item) {

                                                                                        $html .= '  <div class="gallery-item position-relative">';
                                                                                        $html .= '      <div class="media-wrapper-1x1">';
                                                                                        $html .= '          <a href="'. Base::getUploadURL($item->getImage->name, $item->getImage->dir) .'" title="' .$request->name.'" target="_blank">';
                                                                                        $html .= '              <img class="img-cover" src="'. Base::getUploadURL($item->getImage->name, $item->getImage->dir) .'">';
                                                                                        $html .= '          </a>';
                                                                                        $html .= '      </div>';
                                                                                        $html .= '  </div>';
                                                                                    }

                                                                                    return response()->json([
                                                                                        'result' => 1,
                                                                                        'html' => $html,
                                                                                        'total_page' => $business_galleries->lastPage()
                                                                                        ]);
                                                                                    }
                                                                                }
