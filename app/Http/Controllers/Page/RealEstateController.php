<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\RealEstateRequest;
use App\Mail\ClassifyContact;

use App\Models\Category;
use App\Models\RealEstate;
use App\Models\City;
use App\Models\Base;
use App\Models\ImageFactory;
use App\Models\Gallery;
use App\Models\Param;
use App\Models\District;
use App\Models\JobSearching;
use App\Models\PosteNotification;

class RealEstateController extends Controller
{
    public function __construct() {
        parent::__construct();

        $this->data['realestate_type_list'] = Category::getCategoryListFromParam('realestate-type', 'category');
        $this->data['realestate_category_list'] = Category::getCategoryListFromParam('realestate-form', 'category');
        $this->data['realestate_price_list'] = Category::getCategoryListFromParam('realestate-price', 'category');
        $this->data['realestate_bedroom_list'] = Category::getCategoryListFromParam('realestate-bedroom', 'category');

        $this->data['type_search_id'] = 0;
        $this->data['category_search_id'] = 0;
        $this->data['price_search_id'] = 0;
        $this->data['bedroom_search_id'] = 0;
        $this->data['searchKeywords'] = '';
    }

    public function index(Request $request) {
        $articleList = RealEstate::with(['type', 'city', 'price', 'category']);

        if (!empty($request->type_search_id)) {
            $this->data['type_search_id'] = $request->type_search_id;
            $articleList = $articleList->where('type_id', $request->type_search_id);
        }

        if (!empty($request->category_serch_id)) {
            $this->data['category_serch_id'] = $request->category_serch_id;
            $articleList = $articleList->where('category_id', $request->category_serch_id);
        }

        if (!empty($request->bedroom_search_id)) {
            $this->data['bedroom_search_id'] = $request->nationality_search_id;
            $articleList = $articleList->where('bedroom_id', $request->nationality_search_id);
        }

        if (!empty($request->price_search_id)) {
            $this->data['price_search_id'] = $request->price_search_id;
            $articleList = $articleList->where('price_id', $request->price_search_id);
        }

        if (!empty($request->searchKeywords)) {
            $this->data['searchKeywords'] = $request->searchKeywords;
            $articleList = $articleList->where('name', 'LIKE', $request->searchKeywords);
        }

        $articleList = $articleList->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.index')->with($this->data);
    }

    public function type($type) {
        $key = strrpos($type, '-');
        $slug = substr($type, 0, $key);
        $type_id = substr($type, $key + 1);

        $type = Category::find($type_id);
        if(is_null($type) || $type->tag != RealEstate::PARAM_TYPE_ID) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($type->slug != $slug) {
            return redirect()->route('get_real_estate_type_route', $type->slug.'-'.$type->id);
        }

        $articleList = RealEstate::with(['type', 'city', 'price', 'category'])->where('type_id', $type_id)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.index')->with($this->data);
    }

    public function price($price) {
        $key = strrpos($price, '-');
        $slug = substr($price, 0, $key);
        $price_id = substr($price, $key + 1);

        $categoryItem = Category::find($price_id);

        if(is_null($categoryItem) || $categoryItem->tag != RealEstate::PARAM_PRICE_ID) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if($categoryItem->slug != $slug) {
            return redirect()->route('get_real_estate_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }


        $articleList = RealEstate::with(['type', 'city', 'price', 'category'])->where('price_id', $price_id)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.index')->with($this->data);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $categoryId = substr($category, $key + 1);

        $categoryItem = Category::find($categoryId);
        if(is_null($categoryItem) || $tycategoryItem->tag != RealEstate::PARAM_CATEGORY_ID) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if( $categoryItem->slug != $slug ) {
            return redirect()->route('get_real_estate_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $articleList = RealEstate::with(['type', 'city', 'price', 'category'])->where('category_id', $categoryId)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.index')->with($this->data);
    }

    public function bedroom($bedroom) {
        $key = strrpos($bedroom, '-');
        $slug = substr($bedroom, 0, $key);
        $bedroom_id = substr($bedroom, $key + 1);

        $categoryItem = Category::find($bedroom_id);
        if(is_null($categoryItem) || $tycategoryItem->tag != RealEstate::PARAM_BEDROOM_ID) {
            $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
            $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
            return view('errors.404')->with($this->data);
        }

        if( $categoryItem->slug != $slug ) {
            return redirect()->route('get_real_estate_bedroom_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $articleList = RealEstate::with(['type', 'city', 'price', 'category'])->where('bedroom_id', $bedroom_id)->orderBy('updated_at', 'DESC')->paginate(20);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.index')->with($this->data);
    }

    public function getUpdate($article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        $article = RealEstate::withTrashed()->find($id);

        if (is_null($article)) {
            if ($id != 0) {
                $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
                $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
                return view('errors.404')->with($this->data);
            }

            $name = '';
            $firstImage = '';
            $secondImage = '';
            $categoryId = 0;
            $typeId = 0;
            $priceId = 0;
            $bedroomId = 0;
            // $cityId = 0;
            // $districtId = 0;
            $content = '';
            $full_furniture = false;
            $internet = false;
            $bathtub = false;
            $pool = false;
            $gym = false;
            $electronic = false;
            $television = false;
            $kitchen = false;
            $garage = false;
            $security = false;
            $phone = '';
            $email = '';
            $showPhone = false;
            $articleSlug = '';
            // $district_list = [];

            $this->loadPageInfoFromChild('real-estate', 'add');
        } else {
            if ($article->user_id != Auth::user()->id) {
                $this->pageTitle = 'Page Not Found | ミャンマー生活情報サイトPOSTE（ポステ）';
                $this->pageDescription = 'ミャンマー・ヤンゴンで最大級の日系生活情報サイト。「POSTE（ポステ）」ではミャンマー・ヤンゴンのニュースやレストラン、スパ、ホテルなどの生活・観光情報が充実。ミャンマーの治安や通貨、物価、ミャンマー料理の美味しいレストランなど生活や観光に必要な全ての情報がまとまっています。【ポステ】';
                return view('errors.404')->with($this->data);
            }

            $name = $article->name;
            $categoryId = $article->category_id;
            if (!is_null($article->getFirstImage)) {
                $firstImage = Base::getUploadURL($article->getFirstImage->name, $article->getFirstImage->dir);
            } else {
                $firstImage = '';
            }
            if (!is_null($article->getSecondImage)) {
                $secondImage = Base::getUploadURL($article->getSecondImage->name, $article->getSecondImage->dir);
            } else {
                $secondImage = '';
            }
            $typeId = $article->type_id;
            $priceId = $article->price_id;
            $bedroomId = $article->bedroom_id;
            // $cityId = $article->city_id;
            // $districtId = $article->district_id;
            $content = $article->content;
            $full_furniture = $article->full_furniture;
            $internet = $article->internet;
            $bathtub = $article->bathtub;
            $pool = $article->pool;
            $gym = $article->gym;
            $electronic = $article->electronic;
            $television = $article->television;
            $kitchen = $article->kitchen;
            $garage = $article->garage;
            $security = $article->security;
            $email = $article->email;
            $phone = $article->phone;
            if ($article->show_phone_num) {
                $showPhone = true;
            } else {
                $showPhone = false;
            }
            $articleSlug = $article->slug . '-' . $article->id;

            // $district_list = District::getDistrictListFromCity($article->city_id);

            $this->loadPageInfoFromChild('real-estate', 'edit');
        }

        if (old('name')) {
            $name = old('name');
        }
        if (old('category_id')) {
            $categoryId = old('category_id');
        }
        if (old('type_id')) {
            $typeId = old('type_id');
        }
        if (old('price_id')) {
            $priceId = old('price_id');
        }
        if (old('bedroom_id')) {
            $bedroomId = old('bedroom_id');
        }

        if (old('content')) {
            $content = old('content');
        }
        if (old('full_furniture')) {
            $full_furniture = old('full_furniture');
        }
        if (old('internet')) {
            $internet = old('internet');
        }
        if (old('bathtub')) {
            $bathtub = old('bathtub');
        }
        if (old('pool')) {
            $pool = old('pool');
        }
        if (old('gym')) {
            $gym = old('gym');
        }
        if (old('electronic')) {
            $electronic = old('electronic');
        }
        if (old('television')) {
            $television = old('television');
        }
        if (old('kitchen')) {
            $kitchen = old('kitchen');
        }
        if (old('garage')) {
            $garage = old('garage');
        }
        if (old('security')) {
            $security = old('security');
        }
        if (old('email')) {
            $email = old('email');
        }
        if (old('phone')) {
            $phone = old('phone');
        }
        if (old('show_phone_num')) {
            $showPhone = old('show_phone_num');
        }

        $this->data['articleSlug'] = $articleSlug;
        $this->data['name'] = $name;
        $this->data['categoryId'] = $categoryId;
        $this->data['typeId'] = $typeId;
        // $this->data['cityId'] = $cityId;
        $this->data['priceId'] = $priceId;
        $this->data['bedroomId'] = $bedroomId;
        // $this->data['districtId'] = $districtId;
        $this->data['full_furniture'] = $full_furniture;
        $this->data['internet'] = $internet;
        $this->data['pool'] = $pool;
        $this->data['bathtub'] = $bathtub;
        $this->data['gym'] = $gym;
        $this->data['electronic'] = $electronic;
        $this->data['television'] = $television;
        $this->data['kitchen'] = $kitchen;
        $this->data['garage'] = $garage;
        $this->data['security'] = $security;
        $this->data['email'] = $email;
        $this->data['phone'] = $phone;
        $this->data['showPhone'] = $showPhone;
        $this->data['content'] = $content;
        $this->data['firstImage'] = $firstImage;
        $this->data['secondImage'] = $secondImage;
        // $this->data['district_list'] = $district_list;

        return view('www.pages.real-estate.update')->with($this->data);
    }

    public function postUpdate(RealEstateRequest $request, $article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        if ($request->show_phone_num != 1) {
            $showPhone = false;
        } else {
            $showPhone = true;
        }
        if($request->full_furniture != 1) {
            $full_furniture = false;
        } else {
            $full_furniture = true;
        }
        if($request->internet != 1) {
            $internet = false;
        } else {
            $internet = true;
        }
        if($request->bathtub != 1) {
            $bathtub = false;
        } else {
            $bathtub = true;
        }
        if($request->pool != 1) {
            $pool = false;
        } else {
            $pool = true;
        }
        if($request->gym != 1) {
            $gym = false;
        } else {
            $gym = true;
        }
        if($request->electronic != 1) {
            $electronic = false;
        } else {
            $electronic = true;
        }
        if($request->television != 1) {
            $television = false;
        } else {
            $television = true;
        }
        if($request->kitchen != 1) {
            $kitchen = false;
        } else {
            $kitchen = true;
        }
        if($request->garage != 1) {
            $garage = false;
        } else {
            $garage = true;
        }
        if($request->security != 1) {
            $security = false;
        } else {
            $security = true;
        }


        $galleryId1 = 0;
        if ($request->hasFile('image1')) {
            $file = $request->image1;

            if (!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'realestate', 'image');
                $galleryId1 = $gallery_id_arr[0];
            }
        }
        $galleryId2 = 0;
        if ($request->hasFile('image2')) {
            $file = $request->image2;

            if (!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'realestate', 'image');
                $galleryId2 = $gallery_id_arr[0];
            }
        }
        $pre_image1 = $request->pre_image1;
        $pre_image2 = $request->pre_image2;

        $data = array(
            'name' => $request->name,
            'slug' => str_slug($request->name, '-'),
            'category_id' => $request->category_id,
            'type_id' => $request->type_id,
            'price_id' => $request->price_id,
            'bedroom_id' => $request->bedroom_id,
            'content' => $request->content,
            /* 'city_id' => $request->city_id, */
            /* 'district_id' => $request->district_id, */
            'first_image' => $galleryId1,
            'second_image' => $galleryId2,
            'phone' => $request->phone,
            'email' => $request->email,
            'show_phone_num' => $showPhone,
            'full_furniture' => $full_furniture,
            'internet' => $internet,
            'bathtub' => $bathtub,
            'gym' => $gym,
            'pool' => $pool,
            'electronic' => $electronic,
            'television' => $television,
            'kitchen' => $kitchen,
            'garage' => $garage,
            'security' => $security,
            'user_id' => Auth::user()->id,
            'pre_image1' => $pre_image1,
            'pre_image2' => $pre_image2
        );

        $result = RealEstate::updateItem($id, $data);

        return redirect()->route('get_real_estate_list_route');
    }

    public function getList() {
        $articleList = RealEstate::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.real-estate.list')->with($this->data);
    }

    public function detail($article) {
        $key = strrpos($article, '-');
        $slug = substr($article, 0, $key);
        $id = substr($article, $key + 1);

        $article = RealEstate::with(['getUser', 'category', 'type', 'price', 'bedroom', 'getFirstImage', 'getSecondImage', 'district', 'city'])->find($id);

        if(is_null($article)) {
            $this->pageTitle = 'PAGE NOT FOUND';
            return view('errors.404')->with($this->data);
        }

        if($article->slug != $slug) {
            return redirect()->route('get_real_estate_detail_route', $article->slug.'-'.$article->id);
        }

        $this->data['article'] = $article;

        $this->loadPageInfoFromChild('real-estate', '', $article);

        return view('www.pages.real-estate.detail')->with($this->data);
    }

    public function contact(Request $request, $article_id) {
        $id = $article_id;
        $article = RealEstate::with(['getUser', 'category', 'type', 'price', 'bedroom', 'getFirstImage', 'getSecondImage', 'district', 'city'])->find($id);

        if (is_null($article)) {
            return resonse()->json(['result' => 0, 'error' => 'Can not find any article']);
        }

        $name_message = $request->contact_classify_name;
        $email_message = $request->contact_classify_email;
        $subject_message = $request->contact_classify_subject;
        $messageContent = $request->contact_classify_message;

        $itemContent = '<b>'.$article->name . "</b><br/>";
        $itemContent .= "タイプ: " . $article->category->name . "<br/>";
        $itemContent .= "賃料: " . $article->price->name . "<br/>";
        $itemContent .= "ベットルーム: " . $article->bedroom->name . "<br/><br/>";
        $itemContent .= "備考: " . $article->content . "<br/><br/>";
        $itemContent .= "更新日: " . $article->updated_at . "<br/>";

        if (!empty($article->email)) {
            $email = $article->email;
        } else {
            $email = $article->getUser->email;
        }

        $link = route('get_real_estate_detail_route', $article->slug . '-' . $article->id);

        Mail::to($email)->bcc('thong@poste-vn.com')->send(new ClassifyContact($email_message, $name_message, $subject_message, $messageContent, $itemContent, $link));

        if (Mail::failures()) {
            return response()->json(['result' => 0, 'error' => 'Sent mail error']);
        }

        $owner_id = $article->user_id;
        $data = array(
            'email' => $email_message,
            'owner_id' => $owner_id,
            'post_id' => $id,
            'content' => $messageContent,
            'post_type' => 'realestate',
            'name' => $name_message,
            'type_id' => PosteNotification::TYPE_FEEDBACK
        );

        $feedback_item = PosteNotification::create($data);
        if ($feedback_item) {
            return response()->json(['result' => 1]);
        }
    }

    public function postDelete(Request $request) {
        if (!Auth::check()) {
            return response()->json([
                'result' => 0,
                'error' => 'You must login!!!!'
                ]);
            }

            $id = $request->id;

            $result = RealEstate::deleteItem($id);

            if ($result['result']) {
                $articleList = RealEstate::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);

                $view = view('www.pages.real-estate.list-table')->with(['articleList' => $articleList])->render();

                return response()->json([
                    'result' => 1,
                    'view' => $view
                    ]);
                }

                return response()->json($result);
            }
        }
