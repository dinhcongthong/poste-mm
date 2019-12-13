<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\PosteTown;
use App\Models\User;
use App\Models\Base;
use App\Models\PosteNotification;
use App\Models\TownGallery;
use App\Models\TownMenu;
use App\Models\TownMenuDetail;
use App\Models\TownPDFMenu;
use App\Models\TownRegClose;
use App\Models\Gallery;

class TownController extends Controller
{
    public function index() {
        return view('user-setting.pages.town.index')->with($this->data);
    }

    public function changeStatus (Request $request) {
        $id = $request->id;
        return PosteTown::changeStatus($id);
    }

    public function loadDataTable (Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'expired_date',
            3 => 'last_updated',
            4 => 'status',
            5 => 'edit',
            6 => 'delete'
        );

        $totalData = Auth::user()->getTownPage()->withTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $town_list = Auth::user()->getTownPage()->withTrashed()->orderBy($order, $dir)->offset($start)->limit($limit)->get();
        } else {
            $search = $request->input('search.value');

            $town_list = Auth::user()->getTownPage()->withTrashed()
            ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('end_date', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")
                ->orderBy($order, $dir)->offset($start)->limit($limit)->get();

            $totalFiltered = Auth::user()->getTownPage()->withTrashed()
            ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('end_date', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")->count();
        }

        $data = array();

        if (!empty($town_list)) {
            foreach ($town_list as $town) {
                $nestedData['id']  = $town->id;
                
                $html = '<a href="' . route('get_town_detail_route', $town->slug.'-'.$town->id) .'" target="_blank" class="d-block h5 m-0">';
                $html .=    '<i class="fas fa-eye mr-2"></i>' . $town->name;
                $html .= '</a>';
                $nestedData ['name'] = $html;
                $nestedData['expired_date'] = $town->end_date;
                $nestedData['last_updated'] = date_format($town->updated_at, "Y-m-d H:i:s");

                $html = '<a href="#" class="town-change-status" data-id="'.$town->id .'">';
                if (!$town->trashed()) {
                    $html .= '<i class="fas fa-check-circle text-success" title="Activated"></i>';
                } else {
                    $html .= '<i class="fas fa-times-circle text-danger" title="Pending"></i>';
                }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $html = '<a class="mx-1" href="'. route('get_town_edit_route', ['id' => $town->id]) .'">';
                $html .= '<i class="fas fa-edit text-primary"></i>';
                $html .= '</a>';
                $nestedData['edit'] = $html;

                $html = '<a href="#" class="text-center align-middle nav-link text-danger btn-delete-town p-0" data-id="'. $town->id .'">';
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

    public function postDelete(Request $request) {
        $id = $request->id;
        $page = $request->page_type ?? 'user-setting';
        $town = PosteTown::with(['getGalleryImages', 'getMenuList.getDetail.getImage', 'getPDFFiles', 'getRegularClose'])->find($id);

        // Check article is not exists or user don't permission to delete article
        if(is_null($town) || ($town->owner_id != 0 && $town->owner_id != Auth::user()->id) || ($town->owner_id == 0 && Auth::user()->type_id != User::TYPE_ADMIN)) {
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
                Gallery::clearGallery($town->avatar, 'poste-town', $town->id);

                // Check Town Gallery and Delete
                $gallery_list = $town->getGalleryImages;
                foreach ($gallery_list as $item) {
                    TownGallery::deleteItem($item->id);
                }

                // Check Town Menu and Delete
                $menu_list = $town->getMenuList;

                foreach ($menu_list as $menu) {
                    $menu_detail = $menu->getDetail->each(function($item, $key) {
                        if(!is_null($item->getImage)) {
                            Gallery::clearGallery($item->food_image, 'town-food', $item->id);
                        }
                        $item->delete();
                    });

                    $menu->delete();
                }

                // Check And Delete PDF File
                $pdf_list = $town->getPDFFiles->each(function($item, $key) {
                    TownPDFMenu::deletePDF($item->id);
                });

                // Check and delete TơwnRegular
                $regular_list = $town->getRegularClose->each(function($item, $key) {
                    $item->delete();
                });

                $town->forceDelete();

                DB::commit();

                // Remder table view and response to user
                if($page == 'user-setting') {
                    $view = view('user-setting.pages.town.table')->with($this->data)->render();
                } elseif($page == 'admin') {
                    $this->data['town_list'] =PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->get();
                    $view = view('admin.pages.poste-town.table')->with($this->data)->render();
                }

                return response()->json([
                    'result' => 1,
                    'view' => $view
                    ]);
                } catch(\Exception $e) {
                    DB::rollBack();

                    return response()->json([
                        'result' => 0,
                        'error' => $e->getMessage(),
                        'line' => $e->getLine()
                        ]);
                    }
                }
            }
