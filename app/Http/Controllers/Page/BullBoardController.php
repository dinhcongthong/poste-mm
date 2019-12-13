<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\BullBoardRequest;
use App\Mail\ClassifyContact;

use App\Models\Category;
use App\Models\BullBoard;
use App\Models\Base;
use App\Models\ImageFactory;
use App\Models\Gallery;
use App\Models\Param;
use App\Models\PosteNotification;

class BullBoardController extends Controller
{

    public function __construct() {
        parent::__construct();

        $this->data['bullboardCategoryList'] = Category::getCategoryListFromParam('bullboard', 'category');

        $this->data['categoryIdSearch'] = 0;
        $this->data['searchKeywords'] = '';
    }

    public function index(Request $request) {
        $articleList = BullBoard::with('category');

        if(isset($request->category_id)) {
            $this->data['categoryIdSearch'] = $request->category_id;
            $articleList = $articleList->where('category_id', $request->category_id);
        }

        if(isset($request->searchKeywords)) {
            $this->data['searchKeywords'] = $request->searchKeywords;
            $searchKeywords = $request->searchKeywords;

            $articleList = $articleList->where(function($query) use($searchKeywords) {
                $query->orWhere('name', 'LIKE', $searchKeywords)->orWhere('content', 'LIKE', $searchKeywords);
            });
        }

        $articleList = $articleList->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.bullboard.index')->with($this->data);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $categoryId = substr($category, $key + 1);

        $categoryItem = Category::find($categoryId);
        if(is_null($categoryItem)) {
            $this->pageTitle = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        if($categoryItem->slug != $slug) {
            return redirect()->route('get_bullboard_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $articleList = BullBoard::with('category')->where('category_id', $categoryId)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.bullboard.index')->with($this->data);
    }

    public function getUpdate($article = 0) {

        $id = explode('-', $article);
        $id = end($id);

        $article = Bullboard::withTrashed()->find($id);

        if(is_null($article)) {
            if($id != 0) {
                $this->pageTitle = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $name = '';
            $categoryId = 0;
            $address = '';
            $firstImage = '';
            $secondImage = '';
            $startDate = '';
            $endDate = '';
            $content = '';
            $email = '';
            $phone = '';
            $showPhone = false;
            $articleSlug = '';

            $this->loadPageInfoFromChild('bullboard', 'add');
        } else {
            if($article->user_id != Auth::user()->id) {
                $this->pageTitle = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $name = $article->name;
            $categoryId = $article->category_id;
            $address = $article->address;
            if(!is_null($article->getFirstImage)) {
                $firstImage = Base::getUploadURL($article->getFirstImage->name, $article->getFirstImage->dir);
            } else {
                $firstImage = '';
            }
            if(!is_null($article->getSecondImage)) {
                $secondImage = Base::getUploadURL($article->getSecondImage->name, $article->getSecondImage->dir);
            } else {
                $secondImage = '';
            }
            $startDate = $article->start_date;
            $endDate = $article->end_date;
            $content = $article->content;
            $email = $article->email;
            $phone = $article->phone;
            if($article->show_phone_num) {
                $showPhone = true;
            } else {
                $showPhone = false;
            }
            $articleSlug = $article->slug.'-'.$article->id;

            $this->loadPageInfoFromChild('bullboard', 'edit');
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('category_id')) {
            $categoryId = old('category_id');
        }
        if(old('address')) {
            $address = old('address');
        }
        if(old('start_date')) {
            $startDate = old('start_date');
        }
        if(old('end_date')) {
            $endDate = old('end_date');
        }
        if(old('email')) {
            $email = old('email');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('show_phone_num')) {
            $showPhone = old('show_phone_num');
        }
        if(old('content')) {
            $content = old('content');
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['categoryId'] = $categoryId;
        $this->data['address'] = $address;
        $this->data['startDate'] = $startDate;
        $this->data['endDate'] = $endDate;
        $this->data['email'] = $email;
        $this->data['phone'] = $phone;
        $this->data['showPhone'] = $showPhone;
        $this->data['content'] = $content;
        $this->data['firstImage'] = $firstImage;
        $this->data['secondImage'] = $secondImage;
        $this->data['articleSlug'] = $articleSlug;

        return view('www.pages.bullboard.update')->with($this->data);
    }

    public function postUpdate(BullBoardRequest $request, $article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        $startDate = date_create_from_format('Y-m-d', $request->start_date);
        $endDate = date_create_from_format('Y-m-d', $request->end_date);

        $showPhone = true;
        if($request->show_phone_num != 1) {
            $showPhone = false;
        }

        $galleryId1 = 0;
        if($request->hasFile('image1')) {
            $file = $request->image1;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'bullboard', 'image');

                $galleryId1 = $gallery_id_arr[0];
            }
        }
        $galleryId2 = 0;
        if($request->hasFile('image2')) {
            $file = $request->image2;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'bullboard', 'image');
                $galleryId2 = $gallery_id_arr[0];
            }
        }

        $data = array(
            'name' => $request->name,
            'slug' => str_slug($request->name, '-'),
            'category_id' => $request->category_id,
            'address' => $request->address,
            'start_date' => $startDate ? $startDate->format('Y-m-d') : null,
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'content' => $request->content,
            'email' => $request->email,
            'phone' => $request->phone,
            'show_phone_num' => $showPhone,
            'first_image' => $galleryId1,
            'second_image' => $galleryId2,
            'user_id' => Auth::user()->id,
            'pre_image1' => $request->pre_image1,
            'pre_image2' => $request->pre_image2
        );

        $result = BullBoard::updateItem($id, $data);

        return redirect()->route('get_bullboard_list_route');
    }

    public function postDelete(Request $request) {
        if(!Auth::check()) {
            return response()->json([
                'result' => 0,
                'error' => 'You must login!!!!'
            ]);
        }

        $id = $request->id;

        $result = BullBoard::deleteItem($id);

        if($result['result']) {
            $articleList = BullBoard::getListByUserId(Auth::user()->id, 10, true);

            $this->data['articleList'] = $articleList;

            $view = view('www.pages.bullboard.list-table')->with($this->data)->render();

            return response()->json([
                'result' => 1,
                'view' => $view
            ]);
        }

        return response()->json($result);
    }

    public function getList() {
        $articleList = BullBoard::getListByUserId(Auth::user()->id, 10, true);

        $this->data['articleList'] = $articleList;

        return view('www.pages.bullboard.list')->with($this->data);
    }

    public function detail($article) {
        $key = strrpos($article, '-');
        $slug = substr($article, 0, $key);
        $id = substr($article, $key + 1);

        $article = BullBoard::with(['category', 'getUser', 'getFirstImage', 'getSecondImage'])->find($id);

        if(is_null($article)) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }
        if($article->slug != $slug) {
            return redirect()->route('get_bullboard_detail_route', $article->slug.'-'.$article->id);
        }

        $this->data['article'] = $article;

        $this->loadPageInfoFromChild('bullboard', '', $article);

        return view('www.pages.bullboard.detail')->with($this->data);
    }

    public function contact(Request $request, $article_id) {
        $id = $article_id;
        $article = BullBoard::with(['category', 'getUser'])->find($id);

        if(is_null($article)) {
            return resonse()->json(['result' => 0, 'error' => 'Can not find any article']);
        }

        $name_message = $request->contact_classify_name;
        $email_message = $request->contact_classify_email;
        $subject_message = $request->contact_classify_subject;
        $messageContent = $request->contact_classify_message;

        $itemContent = '<b>'.$article->name.'</b><br/>';
        $itemContent .= "<b>情報別:</b> ".$article->category->name."<br/>";
        $itemContent .= "<b>アドレス:</b> ".$article->address;
        $itemContent.= "<br/>";
        if(!is_null($article->start_date)) {
            $itemContent .= "<b>日程:</b> " . date('Y-m-d', strtotime($article->start_date));

            if(!is_null($article->end_date) && $article->start_date != $article->end_date) {
                $itemContent .= ' ~ '.date('Y-m-d', strtotime($article->end_date));
            }

            $itemContent .= "<br/>";
        }
        if(!empty($article->content)) {
            $itemContent .= "<b>希望価格:</b> ".$article->content."<br/>";
        }
        $itemContent .= "<b>更新日:</b> ".date('Y-m-d', strtotime($article->updated_at))."<br/>";

        if(!empty($article->email)) {
            $email = $article->email;
        } else {
            $email = $article->getUser->email;
        }

        $link = route('get_bullboard_detail_route', $article->slug.'-'.$article->id);

        Mail::to($email)->bcc('info-myanmar@poste-vn.com')->send(new ClassifyContact($email_message, $name_message, $subject_message, $messageContent, $itemContent, $link));

        if(Mail::failures()) {
            return response()->json(['result' => 0, 'error' => 'Sent mail error']);
        }

        $owner_id = $article->user_id;
        $data = array(
            'email' => $email_message,
            'owner_id' => $owner_id,
            'post_id' => $id,
            'content' => $messageContent,
            'post_type' => 'bullboard',
            'name' => $name_message,
            'type_id' => PosteNotification::TYPE_FEEDBACK
        );

        $feedback_item = PosteNotification::create($data);

        if ($feedback_item) {
            return response()->json(['result' => 1]);
        }
    }
}
