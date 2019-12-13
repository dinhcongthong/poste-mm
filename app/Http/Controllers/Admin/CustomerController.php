<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Database\Eloquent\Collection ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index() {
        $customerList = Customer::getCustomerList();

        $this->data['customerList'] = $customerList;

        return view('admin.pages.customer.index')->with($this->data);
    }

    public function loadTableData(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'user',
            3 => 'status',
            4 => 'action'
        );

        $totalData = Customer::all()->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customer_list = Customer::with(['getUser'])->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $customer_list =  Customer::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('owner_name', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })

                ->offset($start)->limit($limit)
                ->orderBy($order, $dir)->get();

            $totalFiltered = Customer::with(['getUser'])->where('id', 'LIKE', "%{$search}%")
                ->orWhere('owner_name', 'LIKE', "%{$search}%")
                ->orWhereHas('getUser', function ($query) use ($search) {
                    $query->where('last_name', 'LIKE', "%{$search}%")->orWhere('first_name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = array();

        if (!empty($customer_list)) {
            foreach ($customer_list as $item) {
                $nestedData['id']  = $item->id;

                $html = '<a class="text-dark" href="#id-'. $item->id .'" data-toggle="collapse">';
                $html .=    $item->name;
                $html .=    '<i class="fas fa-caret-down text-success"></i>';
                $html .= '</a>';
                $html .= '<div class="collapse w-100 bg-white mt-2 p-2" id="id-'. $item->id .'">';
                $html .=    '<b>Owner Name: </b>'. $item->owner_name .'<br/>';
                $html .=    '<b>Phone: </b>'. $item->phone .'<br/>';
                $html .=    '<b>Email: </b>'. $item->email .'<br/>';
                $html .= '</div>';
                $nestedData['name'] = $html;

                $nestedData['user'] = getUserName($item->getUser);

                $html = '<a href="#" class="change-status"data-id="'. $item->id .'">';
                if($item->trashed( )) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                }
                else {
                        $html .= '<i class ="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $html = '<a href="'. route('get_customer_edit_ad_route', ['id' => $item->id]) .'" class="edit-customer">';
                $html .=       '<i class="fas fa-edit text-primary"></i>';
                $html .=   '</a>';
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
        $customer = Customer::getCustomerItem($id);
        
        $id = $id;
        $name = '';
        $ownerName = '';
        $phone = '';
        $email = '';
        $userId = 0;
        
        if(!is_null($customer)) {
            $id = $customer->id;
            $name = $customer->name;
            $ownerName = $customer->owner_name;
            $phone = $customer->phone;
            $email = $customer->email;
            $userId = $customer->user_id;
        }
        
        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['ownerName'] = $ownerName;
        $this->data['phone'] = $phone;
        $this->data['email'] = $email;
        $this->data['user_id'] = $userId;
        
        return view('admin.pages.customer.update')->with($this->data);
    }
    
    public function postUpdate(Request $request, $id = 0) {
        $id = $id;
        $data = array(
            'name' => $request->name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => Auth::user()->id
        );

        $result = Customer::updateCustomer($data, $id);

        if($result) {
            return redirect()->route('get_customer_index_ad_route');
        }
    }

    public function ajaxAddCustomer(Request $request) {
        $data = array(
            'name' => $request->customer_name,
            'owner_name' => $request->customer_owner_name,
            'phone' => $request->customer_phone,
            'email' => $request->customer_email,
            'user_id' => Auth::user()->id
        );

        $result = Customer::updateCustomer($data, 0);
        if($result) {
            $html = '<option value="">Please choose Customer</option>';
            $customerList = Customer::getCustomerList();

            foreach($customerList as $key => $item) {
                $html .= '<option value="'.$item->id.'"';
                if($key == 0) {
                    $html .= ' selected';
                }
                $html .= ' >'.$item->name.'</option>';
            }

            return response()->json(['result' => 1, 'html' => $html]);
        }
        return response()->json(['result' => 0, 'error' => 'Add Customer Failed']);
    }
    
    public function changeStatus(Request $request) {
        $id = $request->id;
        $result = Customer::updateStatus($id);
        return $result;
    }
}
