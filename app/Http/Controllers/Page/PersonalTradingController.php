<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\PersonalTradingRequest;
use App\Mail\ClassifyContact;

use App\Models\Category;
use App\Models\Setting;
use App\Models\PersonalTrading;
use App\Models\Gallery;
use App\Models\Base;
use App\Models\ImageFactory;
use App\Models\Param;
use App\Models\PosteNotification;

class PersonalTradingController extends Controller
{
    public function __construct() {
        parent::__construct();

        $this->data['productCategoryList'] = Category::getCategoryListFromParam('personal-trading', 'category');
        $this->data['personalTypeList'] = Setting::getSettingListFromParam('personal-trading-type');

        $this->data['typeIdSearch'] = 0;
        $this->data['categoryIdSearch'] = 0;
        $this->data['searchKeywords'] = '';
    }

    public function index(Request $request) {
        $articleList = PersonalTrading::with(['type', 'category']);

        if(isset($request->type_id)) {
            $this->data['typeIdSearch'] = $request->type_id;
            $articleList = $articleList->where('type_id', $request->type_id);
        }

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

        $articleList = $articleList->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.personal-trading.index')->with($this->data);
    }

    public function type($type) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $typeId = substr($category, $key + 1);

        $type = Setting::find($typeId);

        if(is_null($type) || $type->tag != PersonalTrading::PARAM_TYPE_ID) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($type->slug != $slug) {
            return redirect()->route('get_personal_trading_type_route', $type->slug.'-'.$type->id);
        }

        $articleList = PersonalTrading::with(['type', 'category'])->where('type_id', $typeId)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.personal-trading.index')->with($this->data);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $categoryId = substr($category, $key + 1);

        $categoryItem = Category::find($categoryId);

        if(is_null($categoryItem) || PersonalTrading::PARAM_CATEGORY_ID != $categoryItem->tag) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($categoryItem->slug != $slug) {
            return redirect()->route('get_personal_trading_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $articleList = PersonalTrading::with(['type', 'category'])->where('category_id', $categoryId)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.personal-trading.index')->with($this->data);
    }

    public function getUpdate($article = 0) {
        $this->data['deliveryList'] = Setting::getSettingListFromParam('personal-trading-delivery-method');

        $id = explode('-', $article);
        $id = end($id);

        $article = PersonalTrading::getItem($id, true);

        if(is_null($article)) {
            if($id != 0) {
                $this->pageTitle = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $typeId = 0;
            $categoryId = 0;
            $name = '';
            $price = 0;
            $deliveryId = 0;
            $content = '';
            $address = '';
            $phone = '';
            $email = '';
            $showPhone = false;
            $articleSlug = '';
            $firstImage = '';
            $secondImage = '';

            $this->loadPageInfoFromChild('personal-trading', 'add');
        } else {
            if(Auth::user()->id != $article->user_id) {
                $this->pageTitle = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $typeId = $article->type_id;
            $categoryId = $article->category_id;
            $name = $article->name;
            $price = $article->price;
            $deliveryId = $article->delivery_method;
            $content = $article->content;
            $address = $article->address;
            $phone = $article->phone;
            $email = $article->email;
            if($article->show_phone_num) {
                $showPhone = true;
            } else {
                $showPhone = false;
            }

            $articleSlug = $article->slug.'-'.$article->id;
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

            $this->loadPageInfoFromChild('personal-trading', 'edit');
        }



        if(old('type_id')) {
            $typeId = old('type_id');
        }
        if(old('category_id')) {
            $categoryId = old('category_id');
        }
        if(old('name')) {
            $name = old('name');
        }
        if(old('price')) {
            $price = old('price');
        }
        if(old('delivery_id')) {
            $deliveryId = old('delivery_id');
        }
        if(old('content')) {
            $content = old('content');
        }
        if(old('address')) {
            $address = old('address');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('email')) {
            $email = old('email');
        }
        if(old('show_phone_num')) {
            $showPhone = old('show_phone_num');
        }

        $this->data['id'] = $id;
        $this->data['typeId'] = $typeId;
        $this->data['categoryId'] = $categoryId;
        $this->data['name'] = $name;
        $this->data['price'] = $price;
        $this->data['deliveryId'] = $deliveryId;
        $this->data['content'] = $content;
        $this->data['address'] = $address;
        $this->data['phone'] = $phone;
        $this->data['email'] = $email;
        $this->data['showPhone'] = $showPhone;
        $this->data['articleSlug'] = $articleSlug;
        $this->data['firstImage'] = $firstImage;
        $this->data['secondImage'] = $secondImage;

        return view('www.pages.personal-trading.update')->with($this->data);
    }

    public function postUpdate(PersonalTradingRequest $request, $article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        $showPhone = true;
        if($request->show_phone_num != 1) {
            $showPhone = false;
        }

        $galleryId1 = 0;
        $galleryId2 = 0;
        $deliveryId = 0;
        $pre_image1 = '';
        $pre_image2 = '';

        if($request->type_id != 21) {
            if($request->hasFile('image1')) {
                $file = $request->image1;

                if(!is_null($file)) {
                    $gallery_id_arr = Gallery::uploadImage(array($file), 'personal-trading', 'image');
                    $galleryId1 = $gallery_id_arr[0];
                }
            }
            if($request->hasFile('image2')) {
                $file = $request->image2;

                if(!is_null($file)) {
                    $gallery_id_arr = Gallery::uploadImage(array($file), 'personal-trading', 'image');
                    $galleryId2 = $gallery_id_arr[0];
                }
            }

            $deliveryId = $request->delivery_id;
            $pre_image1 = $request->pre_image1;
            $pre_image2 = $request->pre_image2;
        }

        $data = array(
            'type_id'           => $request->type_id,
            'slug'              => str_slug($request->name, '-'),
            'category_id'       => $request->category_id,
            'name'              => $request->name,
            'price'             => $request->price,
            'delivery_method'   => $deliveryId,
            'content'           => $request->content,
            'address'           => $request->address,
            'first_image'       => $galleryId1,
            'second_image'      => $galleryId2,
            'phone'             => $request->phone,
            'email'             => $request->email,
            'show_phone_num'    => $showPhone,
            'user_id'           => Auth::user()->id,
            'pre_image1'        => $pre_image1,
            'pre_image2'        => $pre_image2
        );

        $article = PersonalTrading::updateItem($id, $data);

        return redirect()->route('get_personal_trading_list_route');
    }

    public function getList() {
        $articleList = PersonalTrading::getListByUserId(Auth::user()->id, 10, true);

        $this->data['articleList'] = $articleList;

        return view('www.pages.personal-trading.list')->with($this->data);
    }

    public function postDelete(Request $request) {
        if(!Auth::check()) {
            return response()->json([
                'result' => 0,
                'error' => 'You must login!!!!'
                ]);
            }

            $id = $request->id;

            $result = PersonalTrading::deleteItem($id);

            if($result['result']) {
                $articleList = PersonalTrading::getListByUserId(Auth::user()->id, 10, true);

                $this->data['articleList'] = $articleList;

                $view = view('www.pages.personal-trading.list-table')->with($this->data)->render();

                return response()->json([
                    'result' => 1,
                    'view' => $view
                    ]);
                }

                return response()->json($result);
            }

            public function detail($article) {
                $key = strrpos($article, '-');
                $slug = substr($article, 0, $key);
                $id = substr($article, $key + 1);

                $article = PersonalTrading::with(['getUser', 'type', 'category', 'delivery', 'getFirstImage', 'getSecondImage'])->find($id);

                if(is_null($article)) {
                    $this->data['pageTitle'] = "Page Not Found";
                    return view('errors.404')->with($this->data);
                }

                if($article->slug != $slug) {
                    return redirect()->route('get_personal_trading_detail_route', $article->slug.'-'.$article->id);
                }

                $this->data['article'] = $article;

                $this->loadPageInfoFromChild('personal-trading', '', $article);

                return view('www.pages.personal-trading.detail')->with($this->data);
            }

            public function contact(Request $request, $article_id)
            {
                $id = $article_id;
                $article = PersonalTrading::with(['getUser', 'type', 'category', 'delivery'])->find($id);

                if (is_null($article)) {
                    return resonse()->json(['result' => 0, 'error' => 'Can not find any article']);
                }

                $name_message = $request->contact_classify_name;
                $email_message = $request->contact_classify_email;
                $subject_message = $request->contact_classify_subject;
                $messageContent = $request->contact_classify_message;

                $itemContent = '<b>' . $article->name . '</b><br/>';
                $itemContent .= "<b>Type:</b> " . $article->type->value . "<br/>";
                $itemContent .= "<b>ジャンル別表示:</b> " . $article->category->name . "<br/>";
                $itemContent .= "<b>希望価格:</b> " . $article->price.'<br/>';
                if (!is_null($article->address)) {
                    $itemContent .= "<b>場所:</b> " . $article->address."<br/>";
                }
                if (!is_null($article->delivery)) {
                    $itemContent .= "<b>商品受け渡し方法:</b> " . $article->delivery->value;

                    $itemContent .= "<br/>";
                }
                if (!empty($article->content)) {
                    $itemContent .= "<b>希望価格:</b> " . $article->content . "<br/>";
                }
                $itemContent .= "<b>更新日:</b> " . date('Y-m-d', strtotime($article->updated_at)) . "<br/>";

                if (!empty($article->email)) {
                    $email = $article->email;
                } else {
                    $email = $article->getUser->email;
                }

                $link = route('get_personal_trading_contact_route', $article->slug . '-' . $article->id);

                Mail::to($email)->bcc('info-myanmar@poste-vn.com')->send(new ClassifyContact($email_message, $name_message, $subject_message, $messageContent, $itemContent, $link));

                if (Mail::failures()) {
                    return response()->json(['result' => 0, 'error' => 'Sent mail error']);
                }
                $owner_id = $article->user_id;
                $data = array(
                    'email' => $email_message,
                    'owner_id' => $owner_id,
                    'post_id' => $id,
                    'content' => $messageContent,
                    'post_type' => 'personaltrading',
                    'name' => $name_message,
                    'type_id' => PosteNotification::TYPE_FEEDBACK
                );

                $feedback_item = PosteNotification::create($data);
                if ($feedback_item) {
                    return response()->json(['result' => 1]);
                }
            }
        }
