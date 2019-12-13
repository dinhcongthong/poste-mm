<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\PosteTown;
use App\Models\User;
use App\Models\Customer;

class PosteTownController extends Controller
{
    public function index() {
        // $town_list = PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->get();

        // $this->data['town_list'] = $town_list;

        $user_list = User::all();
        $customer_list = Customer::all();

        $this->data['user_list'] = $user_list;
        $this->data['customer_list'] = $customer_list;

        return view('admin.pages.poste-town.index')->with($this->data);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'category',
            3 => 'owner',
            4 => 'promotion-owner',
            5 => 'info',
            6 => 'status',
            7 => 'action'
        );

        $totalData = PosteTown::withTrashed()->get()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $town_list = PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->offset($start)->limit($limit)->orderBy($order, $dir)->get();
             // $town_list = PosteTown::withTrashed()->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $town_list =  PosteTown::withTrashed()->with(['getOwner', 'getUser', 'getCustomer', 'getCategory'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();

            $totalFiltered = PosteTown::withTrashed()->with(['getOwner', 'getUser', 'getCustomer', 'getCategory'])->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getUser', function($query) use($search) {
                $query->where('first_name', 'LIKE', "%{$search}%")->orWhere('last_name', 'LIKE', "%{$search}%");
            })->count();
        }

        $data = array();


        if(!empty($town_list)) {
            foreach ($town_list as $item) {
                if($item->fee == PosteTown::SALE_INFORMING && $item->end_date >= date('Y-m-d')) {
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
                $html .=        '<a href="'.route('get_town_detail_route', $item->slug.'-'.$item->id).'" class="mx-1" target="_blank">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>';
                $nestedData['name']  = $html;

                $html = $item->getCategory->name;
                $nestedData['category']  = $html;


                $html =     getUserName($item->getOwner).'<br/>';
                            if(!is_null($item->getOwner)) {
                $html .=        '<a class="btn-remove-owner text-danger" href="#" data-id="'.$item->id.'">Remove Owner</a><br/>';
                            }
                $html .=        '<a class="change-owner" href="#user-list-modal" data-toggle="modal" data-id="'.$item->id.'">Change Owner</a>';
                $nestedData['owner']  = $html;

                            if( isset($item->getCustomer) ) {
                $html =        $item->getCustomer->name.'</br>';
                            } 
                $html .=        '<a class="change-owner" href="#promotion-list-modal" data-toggle="modal" data-id="'.$item->id.'">Promotion Owner</a>';
                $nestedData['promotion-owner']  = $html;

                $html =     'Updated by: <strong>'.getUserName($item->getUser).'</strong><br/>
                            Created at: <strong>'.$item->created_at.'</strong><br/>
                            Last updated at: <strong> '.$item->updated_at.' </strong><br/>
                            Type:';
                            if($type == 'premium') {
                $html .=         '<label class="badge badge-primary">Premium Page</label>';
                            }
                            elseif($type == 'free_premium') {
                $html .=        '<label class="badge badge-success">Free - In Premium</label>'.'<br/>';
                            }
                            else {
                $html .=        '<label class="badge badge-danger">Free Page</label>';
                            }   
                $html .=    '<a href="'.route('get_poste_town_edit_info', $item->id).'">Edit Info</a>';
                $nestedData['info']  = $html;

                $html =    '<div class="clearfix"></div>';
                        if(!is_null($item->getUser)) {
                            if($item->trashed()) {
                                if($item->getUser->type_id != User::TYPE_ADMIN) {
                $html =            '<button type="button" class="btn btn-danger btn-status" data-type="restore" data-id="'.$item->id.'">Deleted By User</button>';
                                } else {
                $html .=            '<button type="button" class="btn btn-danger btn-status" data-id="'.$item->id.'">Pending</button>';
                                }
                            }
                            else
                $html .=        '<button type="button" class="btn btn-success btn-status" data-id="'.$item->id.'">Normal</button>';
                        }
                $nestedData['status']  = $html;
                    

                $html =         '<a href="'.route('get_town_edit_route', $item->slug.'-'.$item->id).'" target="_blank" class="mx-1 text-primary">
                                    <i class="fas fa-edit text-primary"></i>
                                </a>';
                            if($item->owner_id == 0 || $item->owner_id == Auth::user()->id) {
                $html .=        '<a class="mx-1 btn-delete" href="#" data-id="'.$item->id.'">
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

    /* public function getSetOwner($article_id) {
        $town_item = PosteTown::with('getOwner')->withTrashed()->find($article_id);

        if(is_null($town_item)) {
            return redirect()->route('get_poste_town_index_ad_route');
        }

        $user_list = User::withTrashed()->where('id', '<>', Auth::user()->id)->get();

        $this->data['town_item'] = $town_item;
        $this->data['user_list'] = $user_list;

        return view('admin.pages.poste-town.set-owner')->with($this->data);
    } */

    public function postSetOwner(Request $request) {
        $town_id = $request->town_id;
        $owner_id = $request->owner_id;

        $town_item = PosteTown::withTrashed()->find($town_id);

        if(is_null($town_item)) {
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

        $town_item->owner_id = $owner_id;
        $town_item->save();

        $town_list = PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->get();

        $view = view('admin.pages.poste-town.table')->with(['town_list' => $town_list])->render();

        return response()->json([
            'result' => 1,
            'view' => $view
        ]);
    }

    public function postRemoveOwner(Request $request) {
        $town_id = $request->town_id;

        $town_item = PosteTown::withTrashed()->find($town_id);

        if(is_null($town_item)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find any article'
            ]);
        }

        $town_item->owner_id = 0;
        $town_item->save();

        $town_list = PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->get();

        $view = view('admin.pages.poste-town.table')->with(['town_list' => $town_list])->render();

        return response()->json([
            'result' => 1,
            'view' => $view
        ]);
    }

    public function postSetCustomer(Request $request) {
        $town_id = $request->town_id;
        $customer_id = $request->customer_id;

        $town_item = PosteTown::withTrashed()->find($town_id);

        if(is_null($town_item)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find any article'
            ]);
        }

        $customer = User::find($customer_id);

        if(is_null($customer)) {
            return response()->json([
                'result' => 0,
                'error' => 'Not find Customer'
            ]);
        }

        $town_item->customer_id = $customer_id;
        $town_item->save();

        $town_list = PosteTown::with(['getCategory', 'getUser', 'getOwner', 'getCustomer'])->withTrashed()->get();

        $view = view('admin.pages.poste-town.table')->with(['town_list' => $town_list])->render();

        return response()->json([
            'result' => 1,
            'view' => $view
        ]);
    }

    public function getEditInfo($town_id) {
        $town_item = PosteTown::withTrashed()->find($town_id);

        if(is_null($town_item)) {
            return redirect()->route('get_poste_town_index_ad_route');
        }

        $this->data['town_item'] = $town_item;

        return view('admin.pages.poste-town.edit-info')->with($this->data);
    }

    public function postEditInfo(Request $request, $town_id) {
        $town_item = PosteTown::withTrashed()->find($town_id);

        if(is_null($town_item)) {
            return back()->with(['error' => 'Cannot find any article']);
        }

        if($request->type == 0) {
            $town_item->end_free_date = date('Y-m-d', strtotime($request->end_free_date));
            $town_item->fee = 0;

        } else {
            $town_item->fee = 1;
            $town_item->start_date = date('Y-m-d', strtotime($request->start_date));
            $town_item->end_date = date('Y-m-d', strtotime($request->end_date));
        }

        $town_item->save();

        return redirect()->route('get_poste_town_index_ad_route');
    }

    public function postChangeStatus(Request $request) {
        $id = $request->id;

        $poste_item = PosteTown::withTrashed()->find($id);

        if(is_null($poste_item)) {
            return response()->json([
                'result' => 0,
                'error' => 'Can not find any article',
            ]);
        }

        if($poste_item->trashed()) {
            $poste_item->restore();
            $poste_item->update([
                'user_id' => Auth::user()->id
            ]);
            $status = 1;
        } else {
            $poste_item->delete();
            $poste_item->update([
                'user_id' => Auth::user()->id
            ]);
            $status = 0;
        }

        return response()->json([
            'result' => 1,
            'check' => $status,
            'status' => $poste_item->status
        ]);
    }
}
