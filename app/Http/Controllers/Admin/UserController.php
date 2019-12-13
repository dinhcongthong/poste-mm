<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $userList = User::getUserList();

        $this->data['userList'] = $userList;

        return view('admin.pages.user.index')->with($this->data);
    }

    public function loadTableData (Request $request) {

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'isLetter',
            3 => 'permission',
            4 => 'updated_at',
            5 => 'status',
            6 => 'action'
        );

        $totalData = User::all()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $user_list = User::offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $user_list =  User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")

                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('updated_at', 'LIKE', "%{$search}%")->count();
        }

        $data = array();

        if (!empty($user_list)) {
            foreach ($user_list as $user) {
                $nestedData['id']  = $user->id;

                $html = '<a class="text-dark" href="#id-'. $user->id .'" data-toggle="collapse">';
                $html .=    getUserName($user);
                $html .=    '<i class="fas fa-caret-down text-success"></i>';
                $html .= '</a>';
                $html .= '<div class="collapse w-100 bg-white mt-2 p-2" id="id-'. $user->id .'">';
                $html .=    '<b>Email: </b>'. $user->email .'<br/>';
                $html .=    '<b>Phone: </b>'. $user->phone .'<br/>';
                $html .=    '<b>Gender: </b>'. $user->gender_id ? ' 女性 ' : ' 男性 '.'<br/>';
                $html .=    '<b>DOB: </b>'. $user->birthday .'<br/>';
                $html .=    '<b>Created_at: </b>'. $user->created_at .'';
                $html .= '</div>';
                $nestedData['name'] = $html;

                $html = '<select class="form-control sl-change-letter" data-id="'. $user->id .'">';
                $html .=    '<option value="1" '. ($user->is_news_letter ? 'selected' : '' ) .' >Yes</option>';
                $html .=    '<option value="0" '. ($user->is_news_letter ? 'selected' : '' ) .'>No</option>';
                $html .= '</select>';
                $nestedData['isLetter'] = $html;

                $html = '<select class="form-control sl-change-role" data-id="'. $user->id .'">';
                $html .=    '<option value="1" '. ($user->type_id == 1 ? 'selected' : '' ) .' >Adminstrator</option>';
                $html .=    '<option value="2" '. ($user->type_id == 2 ? 'selected' : '' ) .'>Editor</option>';
                $html .=    '<option value="3" '. ($user->type_id == 3 ? 'selected' : '' ) .'>User</option>';
                $html .= '</select>';
                $nestedData['permission'] = $html;

                $nestedData['updated_at'] = date_format($user->updated_at, "Y-m-d H:i:s");

                $html = '<a class="btn-change-status" href="#" data-id="'. $user->id .'">';
                            if($user->trashed()) {
                $html .=        '<i class="fas fa-times-circle text-danger"></i>';
                            }
                            else {
                $html .=        '<i class="fas fa-check-circle text-success"></i>';
                            }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $html = '<a class="btn-delete" role="button" href="#"  data-id="' . $user->id . '">';
                $html .=    '<i class="fas fa-trash-alt text-danger"></i>';
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

    public function changeLetter(Request $request) {
        $id = $request->id;

        return User::ajaxUpdateNewsLetter($id);
    }

    public function changePermission(Request $request) {
        $id = $request->id;
        $type_id = $request->type_id;

        return user::ajaxUpdatePermission($id, $type_id);
    }

    public function changeStatus(Request $request) {
        $id = $request->id;

        return User::ajaxChangeStatus($id);
    }
}
