<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\JobSearchingRequest;
use App\Mail\ClassifyContact;

use App\Models\JobSearching;
use App\Models\Category;
use App\Models\PosteNotification;

class JobSearchingController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->data['job_searching_type_list'] = Category::getCategoryListFromParam('jobsearching-type', 'category');
        $this->data['job_searching_category_list'] = Category::getCategoryListFromParam('jobsearching-major', 'category');
        $this->data['job_searching_employee_list'] = Category::getCategoryListFromParam('jobsearching-employee', 'category');

        $this->data['type_search_id'] = 0;
        $this->data['category_serch_id'] = 0;
        $this->data['nationality_search_id'] = 0;
        $this->data['searchKeywords'] = '';
    }

    public function index(Request $request) {
        $articleList = JobSearching::with(['type', 'category']);

        if(!empty($request->type_search_id)) {
            $this->data['type_search_id'] = $request->type_search_id;
            $articleList = $articleList->where('type_id', $request->type_search_id);
        }

        if(!empty($request->category_serch_id)) {
            $this->data['category_serch_id'] = $request->category_serch_id;
            $articleList = $articleList->where('category_id', $request->category_serch_id);
        }

        if(!empty($request->nationality_search_id)) {
            $this->data['nationality_search_id'] = $request->nationality_search_id;
            $articleList = $articleList->where('nationality', $request->nationality_search_id);
        }

        if(!empty($request->searchKeywords)) {
            $this->data['searchKeywords'] = $request->searchKeywords;
            $articleList = $articleList->where('name', 'LIKE', $request->searchKeywords);
        }

        $articleList = $articleList->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.job-searching.index')->with($this->data);
    }

    public function type($type) {
        $key = strrpos($type, '-');
        $slug = substr($type, 0, $key);
        $type_id = substr($type, $key + 1);

        $type = Category::find($type_id);

        if(is_null($type) || $type->tag != JobSearching::PARAM_TYPE_ID) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }

        if($type->slug != $slug) {
            return redirect()->route('get_jobsearching_type_route', $type->slug.'-'.$type->id);
        }

        $articleList = JobSearching::with(['type', 'category'])->where('type_id', $type_id)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.job-searching.index')->with($this->data);
    }

    public function category($category) {
        $key = strrpos($category, '-');
        $slug = substr($category, 0, $key);
        $category_id = substr($category, $key + 1);

        $categoryItem = Category::find($category_id);
        if(is_null($categoryItem) && $categoryItem->tag != JobSearching::PARAM_MAJOR_ID) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }
        if( $categoryItem->slug != $slug) {
            return redirect()->route('get_jobsearching_category_route', $categoryItem->slug.'-'.$categoryItem->id);
        }

        $articleList = JobSearching::with(['type', 'category'])->where('category_id', $category_id)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.job-searching.index')->with($this->data);
    }

    public function nationality($national) {
        $key = strrpos($national, '-');
        $slug = substr($national, 0, $key);
        $national_id = substr($national, $key + 1);

        $nationalItem = Category::find($national_id);
        if(is_null($nationalItem) && $nationalItem->tag != JobSearching::PARAM_EMPLOYEE_ID) {
            $this->data['pageTitle'] = 'Page Not Found';
            return view('errors.404')->with($this->data);
        }
        if( $nationalItem->slug != $slug) {
            return redirect()->route('get_jobsearching_nationality_route', $nationalItem->slug.'-'.$nationalItem->id);
        }

        $articleList = JobSearching::with(['type', 'category'])->where('nationality', $national_id)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.job-searching.index')->with($this->data);
    }

    public function getUpdate($article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        $article = JobSearching::withTrashed()->find($id);

        if(is_null($article)) {
            if($id != 0) {
                $this->data['pageTitle'] = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $name = '';
            $type_id = 0;
            $category_id = 0;
            $nationality_id = 0;
            $quantity = 0;
            $content = '';
            $phone = '';
            $email = '';
            $show_phone_num = false;
            $address = '';
            $requirement = '';
            $salary = 0;
            $other_info = '';
            $article_slug = '';

            $this->loadPageInfoFromChild('job-searching', 'add');
        } else {
            if($article->user_id != Auth::user()->id) {
                $this->data['pageTitle'] = 'Page Not Found';
                return view('errors.404')->with($this->data);
            }

            $name = $article->name;
            $type_id = $article->type_id;
            $category_id = $article->category_id;
            $nationality_id = $article->nationality;
            $quantity = $article->quantity;
            $content = $article->content;
            $phone = $article->phone;
            $email = $article->email;
            $show_phone_num = $article->show_phone_num;
            $address = $article->address;
            $requirement = $article->requirement;
            $salary = $article->salary;
            $other_info = $article->other_info;
            $article_slug = $article->slug.'-'.$article->id;

            $this->loadPageInfoFromChild('job-searching', 'edit');
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('type_id')) {
            $type_id = old('type_id');
        }
        if(old('category_id')) {
            $category_id = old('category_id');
        }
        if(old('nationality_id')) {
            $nationality_id = old('nationality_id');
        }
        if(old('quantity')) {
            $quantity = old('quantity');
        }
        if(old('content')) {
            $content = old('content');
        }
        if(old('phone')) {
            $phone = old('phone');
        }
        if(old('email')) {
            $email = old('email');
        }
        if(old('show_phone_num')) {
            $show_phone_num = old('show_phone_num');
        }
        if(old('address')) {
            $address = old('address');
        }
        if(old('requirement')) {
            $requirement = old('requirement');
        }
        if(old('salary')) {
            $salary = old('salary');
        }
        if(old('other_info')) {
            $other_info = old('other_info');
        }

        $this->data['article_slug'] = $article_slug;
        $this->data['name'] = $name;
        $this->data['type_id'] = $type_id;
        $this->data['category_id'] = $category_id;
        $this->data['nationality_id'] = $nationality_id;
        $this->data['quantity'] = $quantity;
        $this->data['content'] = $content;
        $this->data['phone'] = $phone;
        $this->data['email'] = $email;
        if($show_phone_num) {
            $this->data['show_phone_num'] = true;
        } else {
            $this->data['show_phone_num'] = false;
        }
        $this->data['address'] = $address;
        $this->data['requirement'] = $requirement;
        $this->data['salary'] = $salary;
        $this->data['other_info'] = $other_info;

        return view('www.pages.job-searching.update')->with($this->data);
    }

    public function postUpdate(JobSearchingRequest $request, $article = 0) {
        $id = explode('-', $article);
        $id = end($id);

        if($request->show_phone_num) {
            $showPhone = true;
        } else {
            $showPhone = false;
        }

        $data = array(
            'name' => $request->name,
            'slug' => str_slug($request->name, '-'),
            'type_id' => $request->type_id,
            'category_id' => $request->category_id,
            'nationality' => $request->nationality_id,
            'quantity' => $request->quantity,
            'salary' => $request->salary,
            'content' => $request->content,
            'requirement' => $request->requirement,
            'other_info' => $request->other_info,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'show_phone_num' => $showPhone,
            'user_id' => Auth::user()->id
        );

        $result = JobSearching::updateItem($id, $data);

        return redirect()->route('get_job_searching_list_route');
    }

    public function getList() {
        $articleList = JobSearching::withTrashed()->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);

        $this->data['articleList'] = $articleList;

        return view('www.pages.job-searching.list')->with($this->data);
    }

    public function detail($article) {
        $key = strrpos($article, '-');
        $slug = substr($article, 0, $key);
        $id = substr($article, $key + 1);

        $article = JobSearching::with(['getUser', 'category', 'type', 'getNationality'])->find($id);

        if(is_null($article)) {
            $this->pageTitle = 'PAGE NOT FOUND';
            return view('errors.404')->with($this->data);
        }
        if($article->slug != $slug) {
            return redirect()->route('get_jobsearching_detail_route', $article->slug.'-'.$article->id);
        }

        $this->data['article'] = $article;

        $this->loadPageInfoFromChild('job-searching', '', $article);

        return view('www.pages.job-searching.detail')->with($this->data);
    }

    public function contact(Request $request, $article_id)
    {
        $id = $article_id;
        $article = JobSearching::with(['getUser', 'category', 'type', 'getNationality'])->find($id);

        if (is_null($article)) {
            return resonse()->json(['result' => 0, 'error' => 'Can not find any article']);
        }

        $name_message = $request->contact_classify_name;
        $email_message = $request->contact_classify_email;
        $subject_message = $request->contact_classify_subject;
        $messageContent = $request->contact_classify_message;

        $itemContent = '<b>会社名: ' . $article->name . '</b><br/>';
        if($article->quantity != 0) {
            $itemContent .= "<b>採用人数: </b> " . $article->quantity . "<br/>";
        }
        if (!is_null($article->type)) {
            $itemContent .= "<b>アドレス: </b>" . $article->type->name."<br/>";
        }
        if (!is_null($article->getNationality)) {
            $itemContent .= "<b>雇用人種: </b>".$article->getNationality->name."<br/>";
        }
        if (!is_null($article->category)) {
            $itemContent .= "<b>雇用形態: </b>".$article->category->name."<br/>";
        }
        if (!empty($article->requirement)) {
            $itemContent .= "<b>雇用資格: </b>" . $article->requirement . "<br/>";
        }
        if (!empty($article->content)) {
            $itemContent .= "<b>仕事内容: </b>" . $article->content . "<br/>";
        }
        $itemContent .= "<b>勤務地:</b> " . $article->address;

        $itemContent .= "<br/>";
        if (!empty($article->salary)) {
            $itemContent .= "<b>給与: </b>" . $article->salary . "<br/>";
        }
        if (!empty($article->other_info)) {
            $itemContent .= "<b>備考: </b>" . $article->other_info . "<br/>";
        }
        $itemContent .= "<b>更新日:</b> " . date('Y-m-d', strtotime($article->updated_at)) . "<br/>";

        if (!empty($article->email)) {
            $email = $article->email;
        } else {
            $email = $article->getUser->email;
        }

        $link = route('get_jobsearching_detail_route', $article->slug . '-' . $article->id);

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
            'post_type' => 'jobsearching',
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

        $result = JobSearching::deleteItem($id);

        if ($result['result']) {
            $articleList = JobSearching::withTrashed()->where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->paginate(10);

            $view = view('www.pages.job-searching.list-table')->with(['articleList' => $articleList])->render();

            return response()->json([
                'result' => 1,
                'view' => $view
            ]);
        }

        return response()->json($result);
    }
}
