<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Business;
use App\Models\User;
use App\Models\Base;
use App\Models\PosteTown;
use App\Models\Gallery;
use App\Models\PosteNotification;

class BusinessController extends Controller
{
    public function index() {
        return view('user-setting.pages.business.index')->with($this->data);
    }

    public function loadDataTable(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'expired_date',
            3 => 'last_updated',
            4 => 'status',
            5 => 'edit',
            6 => 'delete'
        );

        $totalData = Auth::user()->getBusinessPage()->withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $business_list = Auth::user()->getBusinessPage()->withTrashed()->orderBy($order, $dir)->offset($start)->limit($limit)->get();
        } else {
            $search = $request->input('search.value');

            $business_list = Auth::user()->getBusinessPage()->withTrashed()
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('end_date', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orderBy($order, $dir)->offset($start)->limit($limit)->get();

            $totalFiltered = Auth::user()->getBusinessPage()->withTrashed()
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('end_date', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")->count();
        }

        $data = array();

        if (!empty($business_list)) {
            foreach ($business_list as $business) {
                $nestedData['id']  = $business->id;

                $html = '<a href="' . route('get_business_detail_route', $business->slug . '-' . $business->id) . '" target="_blank" class="d-block h5 m-0">';
                $html .=    '<i class="fas fa-eye mr-2"></i>' . $business->name;
                $html .= '</a>';
                $nestedData['name'] = $html;
                $nestedData['expired_date'] = $business->end_date;
                $nestedData['last_updated'] = date_format($business->updated_at, "Y-m-d H:i:s");

                $html = '<a href="#" class="business-change-status" data-id="' . $business->id . '">';
                if (!$business->trashed()) {
                    $html .= '<i class="fas fa-check-circle text-success" title="Activated"></i>';
                } else {
                    $html .= '<i class="fas fa-times-circle text-danger" title="Pending"></i>';
                }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $html = '<a class="mx-1" href="' . route('get_business_edit_route', ['id' => $business->id]) . '">';
                $html .= '<i class="fas fa-edit text-primary"></i>';
                $html .= '</a>';
                $nestedData['edit'] = $html;

                $html = '<a href="#" class="text-center align-middle nav-link text-danger btn-delete-business p-0" data-id="' . $business->id . '">';
                $html .=    '<i class="far fa-trash-alt m-0"></i>';
                $html .= '</a>';
                $nestedData['delete'] = $html;


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

    public function changeStatus (Request $request) {
        $id = $request->id;
        return Business::changeStatus($id);
    }

    public function postDelete(Request $request) {
        $id = $request->id;
        $page = $request->page_type ?? 'user-setting';

        $business = Business::find($id);

        // Check article is not exists or user don't permission to delete article
        if(is_null($business) || ($business->owner_id != 0 && $business->owner_id != Auth::user()->id) || ($business->owner_id == 0 && Auth::user()->type_id != User::TYPE_ADMIN)) {
            return response()->json([
                'result' => 0,
                'error' => 'Can not find any article ID: ' . $id
            ]);
        }

        // Get Relate term
        /*
        * Begin Transaction in try....catch....
        * If have error, rollback to first status
        * If success, commit to database...
        */
        try {
            // Begin transaction
            DB::beginTransaction();

            // Check avatar file and remove file (include delete file on Server)
            Gallery::clearGallery($business->thumb_id, 'business-avatar', $business->id);

            // Check image Primary Address and delete
            Gallery::clearGallery($business->img_route_guide, 'business-img-primary-map', $business->id);

            // Check and delte PDF File
            if(!empty($business->pdf_url)) {
                $pdf_info = Base::getUploadFilename($business->pdf_url);

                $path = Config::get('image.upload_path').trim($pdf_info['dir']).'/'.trim($pdf_info['filename']);
                if(File::exists($path)) {
                    // File exists
                    $result = File::delete($path);
                }
            }

            // Check and delete Business Gallery
            $business->getBusinessGallery->each(function($item, $key) {
                if(!is_null($item->getImage)) {
                    Gallery::clearGallery($item->gallery_id, 'business-gallery', $item->id);
                }

                $item->delete();
            });

            // Delete Gallery Map
            $business->getMapList->each(function($item, $key) {
                if(!is_null($item->getImage)) {
                    Gallery::clearGallery($item->image_route_guide, 'business-img-map', $item->id);
                }

                $item->delete();
            });

            // Delete Business RElate
            $business->getBusinessRelateList->each(function($item, $key) {
                $item->delete();
            });

            // Delete Business Services
            $business->getServiceList->each(function($item, $key) {
                $item->delete();
            });

            // Force Delete Business
            $business->forceDelete();

            // Commit change to DB
            DB::commit();

            if($page == 'user-setting') {
                $view = view('user-setting.pages.business.table')->with($this->data)->render();
            } elseif($page == 'admin') {
                $article_list = Business::with(['getOwner', 'getUser', 'getCategories'])->withTrashed()->get();
                $view = view('admin.pages.business.table')->with(['article_list' => $article_list])->render();
            }

            return response()->json([
                'result' => 1,
                'view' => $view
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'result' => 0,
                'error' => 'Have error while processing'
            ]);
        }
    }
}
