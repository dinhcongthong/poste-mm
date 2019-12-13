<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalTrading;
use App\Models\Gallery;
use App\Models\Base;
use App\Models\PosteTown;
use App\Models\PosteNotification;

class PersonalTradingController extends Controller
{
    public function postDelete(Request $request) {
        if(!Auth::check()) {
            return response()->json([
                'result' => 0,
                'error' => 'You must login!!!!'
                ]
            );
        }

        $id = $request->id;

        $result = PersonalTrading::deleteItem($id);

        if($result['result']) {
            $articleList = PersonalTrading::getListByUserId(Auth::user()->id, 3, true);

            $this->data['articleList'] = $articleList;

            $view = view('user-setting.pages.home.index')->with($this->data)->render();

            return response()->json([
                'result' => 1,
                'view' => $view
                ]
            );
        }

        return response()->json($result);
    }
}
