<?php

namespace App\Http\Controllers\UserSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\BullBoardRequest;
use App\Models\BullBoard;
use App\Models\PosteTown;
use App\Models\PosteNotification;

class BullBoardController extends Controller
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

        $result = BullBoard::deleteItem($id);

        if($result['result']) {
            $articleList = BullBoard::getListByUserId(Auth::user()->id, 3, true);

            $this->data['articleList'] = $articleList;

            $view = view('www.pages.bullboard.list-table')->with($this->data)->render();

            return response()->json([
                'result' => 1,
                'view' => $view
                ]
            );
        }

        return response()->json($result);
    }
}
