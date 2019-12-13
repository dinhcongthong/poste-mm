<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Business;
use App\Models\User;

class BusinessController extends Controller
{
    public function index() {

        // $article_list = Business::with(['getOwner', 'getUser', 'getCategories'])->withTrashed()->get();
        $user_list = User::all();

        // $this->data['article_list'] = $article_list;
        $this->data['user_list'] = $user_list;

        return view('admin.pages.business.index')->with($this->data);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user',
            3 => 'owner',
            4 => 'info',
            5 => 'status',
            6 => 'action'
        );

        $totalData = Business::withTrashed()->get()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $article_list = Business::withTrashed()->with(['getOwner', 'getUser', 'getCategories'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $article_list =  Business::withTrashed()->with(['getOwner', 'getUser', 'getCategories'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();

            $totalFiltered = Business::withTrashed()->with(['getOwner', 'getUser', 'getCategories'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->count();
        }

        $data = array();


        if(!empty($article_list)) {
            foreach ($article_list as $item) {
                if($item->fee == SALE_INFORMING && $item->end_date >= date('Y-m-d')) {
                    $type = 'premium';
                } else {
                    if($item->end_free_date >= date('Y-m-d')) {
                        $type = 'free_premium';
                    } else {
                        $type = 'free';
                    }
                }

                $html = $item->id;
                $nestedData['id']  = $html;

                $html = $item->name;
                $nestedData['name']  = $html;

                $html = getUserName($item->getUser);
                $nestedData['user']  = $html;

                $html = getUserName($item->getOwner).'<br/>
                    <a class="change-owner" href="#user-list-modal" data-toggle="modal" data-id="'.$item->id.'">Change Owner</a>';
                $nestedData['owner']  = $html;
                

                $html = 'Updated by: <strong>'.getUserName($item->getUser).'</strong><br/>
                        Created at: <strong>'.$item->created_at.'</strong><br/>
                        Last updated at: <strong> '.$item->updated_at.' </strong><br/>
                        Type:';
                        if($type == 'premium') {
                $html .=    '<label class="badge badge-primary">Premium Page</label>';
                        } elseif ($type == 'free_premium') {
                $html .=    '<label class="badge badge-success">Free - In Premium</label>';
                        } else {
                $html .=    '<label class="badge badge-danger">Free Page</label>';
                        }
                $html .=    '<br/>
                        <a href="'.route('get_business_edit_info', $item->id).'">Edit Info</a>';
                $nestedData['info']  = $html;


                $html =    '<div class="clearfix"></div>';
                        if(!is_null($item->getUser)) {
                            if($item->trashed()) {
                                 if($item->getUser->type_id != User::TYPE_ADMIN) {
                $html =             '<button type="button" class="btn btn-danger btn-status" data-type="restore" data-id="'.$item->id.'">Deleted By User</button>';
                                 } else {
                $html .=            '<button type="button" class="btn btn-danger btn-status" data-id="'.$item->id.'">Pending</button>';
                                 }    
                            } 
                            else 
                $html .=         '<button type="button" class="btn btn-success btn-status" data-id="'.$item->id.'">Normal</button>';
                            }
                $nestedData['status']  = $html;
                
                
                $html =    '<a href="'.route('get_business_edit_route', $item->slug.'-'.$item->id).'" target="_blank" class="mx-1 text-primary">
                                <i class="fas fa-edit text-primary"></i>
                            </a>';
                        if($item->owner_id == 0 || $item->owner_id == Auth::user()->id) {
                $html .=    '<a class="mx-1 btn-delete" href="#" data-id="'.$item->id.'">
                                <i class="fas fa-trash text-danger"></i>
                            </a>';
                        }
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
        // return 'json';

    }

    public function postSetOwner(Request $request) {
        $business_id = $request->business_id;
        $owner_id = $request->owner_id;

        $business_item = Business::withTrashed()->find($business_id);

        if(is_null($business_item)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find any article'
            ]);
        }

        $owner = User::find($owner_id);

        if(is_null($owner)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find owner'
            ]);
        }

        $business_item->owner_id = $owner_id;
        $business_item->save();

        $article_list = Business::with(['getOwner', 'getUser', 'getCategories'])->withTrashed()->get();

        $view = view('admin.pages.business.table')->with(['article_list' => $article_list])->render();

        return response()->json([
            'result' => 1,
            'view' => $view
        ]);
    }

    public function postChangeStatus(Request $request) {
        $business_id = $request->business_id;

        $business_item = Business::withTrashed()->find($business_id);

        if(is_null($business_item)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find any article'
            ]);
        }

        if($business_item->trashed()) {
            $status = 1;
            $business_item->restore();
        } else {
            $status = 0;
            $business_item->delete();
        }

        $business_item->update([
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'result' => 1,
            'status' => $status
        ]);
    }

    public function getEditInfo($business_id) {
        $business_item = Business::withTrashed()->find($business_id);

        if(is_null($business_item)) {
            return redirect()->route('get_poste_town_index_ad_route');
        }

        $this->data['business_item'] = $business_item;

        return view('admin.pages.business.edit-info')->with($this->data);
    }

    public function postEditInfo(Request $request, $business_id) {
        $business_item = Business::withTrashed()->find($business_id);

        if(is_null($business_item)) {
            return back()->with(['error' => 'Cannot find any article']);
        }

        if($request->type == 0) {
            $business_item->update([
                'end_free_date' => date('Y-m-d', strtotime($request->end_free_date)),
                'fee' => 0
            ]);
        } else {
            $business_item->update([
                'fee' => 1,
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date))
            ]);
        }

        $business_item->save();

        return redirect()->route('get_business_index_ad_route');
    }

    // public function loadDataTable() {

    // }
}
