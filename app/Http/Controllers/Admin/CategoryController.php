<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Config;

use App\Http\Requests\CategoryRequest;

use App\Models\Category;
use App\Models\Param;
use App\Models\Gallery;
use App\Models\ImageFactory;
use App\Models\Base;

class CategoryController extends Controller
{
    /**
    * Index Function return View Management
    */
    public function index() {
        return view('admin.pages.category.index')->with($this->data);
    }

    public function getUpdate($id = 0) {
        $galleryTags = Param::getCategoryParam();
        $categoryItem = Category::getItem($id, $getTrashed = true);


        if(!is_null($categoryItem)) {
            $tagItem = Param::getParamItem($categoryItem->tag);

            $id = $categoryItem->id;
            $name = $categoryItem->name;
            $english_name = $categoryItem->english_name;
            $slug = $categoryItem->slug;
            $orderNum = $categoryItem->order_num;
            $tag = $categoryItem->tag;
            $icon = $categoryItem->getIcon ? Base::getUploadURL($categoryItem->getIcon->name, $categoryItem->getIcon->dir) : '';
        } else {
            $id = 0;
            $name = '';
            $english_name = '';
            $slug = '';
            $tag = 0;
            $orderNum = 0;
            $icon = '';
        }

        if(old('name')) {
            $name = old('name');
        }
        if(old('english_name')) {
            $english_name = old('english_name');
        }
        if(old('slug')) {
            $slug = old('slug');
        }
        if(old('tag')) {
            $tag = old('tag');
        }
        if(old('order_name')) {
            $orderNum = old('order_num');
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['english_name'] = $english_name;
        $this->data['slug'] = $slug;
        $this->data['tag'] = $tag;
        $this->data['orderNum'] = $orderNum;
        $this->data['icon'] = $icon;

        $this->data['galleryTags'] = $galleryTags;

        return view('admin.pages.category.update')->with($this->data);
    }

    public function postUpdate(CategoryRequest $request, $id = 0) {
        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $tag = $request->tag;
        $galleryId = 0;
        if($request->hasFile('icon')) {
            $file = $request->icon;

            if(!is_null($file)) {
                $tag_item = Param::find($tag);
                $gallery_id_arr = Gallery::uploadImage(array($file), 'category', 'icon', 'icon');

                $galleryId = $gallery_id_arr[0];
            }
        }

        $data = array(
            'name' => $request->name,
            'english_name' => $request->english_name,
            'slug' => $slug,
            'tag' => $tag,
            'order_num' => $request->order_num,
            'icon' => $galleryId,
            'parent_id' => 0,
            'user_id' => Auth::user()->id
        );

        $result = Category::createNew($data, $id);

        if($result) {
            return redirect()->route('get_category_index_ad_route');
        }
    }

    /**
    * Function to change status Category by deleted_at column
    *
    * @param Request $request: Request from client
    *
    * @return json result info
    */
    public function changeStatus(Request $request) {
        $id = $request->id;

        return Category::changeStatus($id);
    }

    /**
     * Function to delete Category
     *
     * @param Request $request: Request from client
     *
     * @return json return result info
     */
    public function postDelete(Request $request) {
        $id = $request->id;

        $category_item = Category::withTrashed()->find($id);

        if(is_null($category_item)) {
            return response()->json([
                'result' => false,
                'errors' => ['Can not find selected article...']
            ]);
        }

        $errors = $category_item->completeRemove();

        if(!empty($errors)) {
            return response()->json([
                'result' => false,
                'errors' => $errors
            ]);
        }

        return response()->json([
            'result' => true
        ]);
    }

    public function loadDataTable(Request $request) {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'tag',
            3 => 'status',
            4 => 'action'
        );

        $totalData = Category::withTrashed()->where('parent_id', 0)->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {
            $category_list = Category::withTrashed()->with(['getTag'])->where('parent_id', 0)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        } else {
            $search = $request->input('search.value');

            $category_list =  Category::withTrashed()->with(['getTag'])->where('parent_id', 0)->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getTag', function($query) use($search) {
                $query->where('news_type', 'LIKE', "%{$search}%");
            })->offset($start)->limit($limit)
            ->orderBy($order, $dir)->get();

            $totalFiltered = Category::withTrashed()->with(['getTag'])->where('parent_id', 0)->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhereHas('getTag', function($query) use($search) {
                $query->where('news_type', 'LIKE', "%{$search}%");
            })->count();
        }

        $data = array();

        if(!empty($category_list)) {
            foreach ($category_list as $category) {
                $nestedData['id']  = $category->id;
                $nestedData['name'] = $category->name;
                $nestedData['tag'] = $category->getTag->news_type.'.'.$category->getTag->tag_type;

                $html = '<a href="#" class="change-status" data-id="'.$category->id.'">';
                if($category->trashed()) {
                    $html .= '<i class="fas fa-times-circle text-danger"></i>';
                } else {
                    $html .= '<i class="fas fa-check-circle text-success"></i>';
                }
                $html .= '</a>';
                $nestedData['status'] = $html;

                $html = '<a class="mx-1" href="'.route('get_category_edit_ad_route', ['id' => $category->id]).'">';
                $html.= '<i class="fas fa-edit text-primary"></i>';
                $html.= '</a>';
                $html.= '<a class="mx-1 delete-btn" href="#" data-id="'.$category->id.'">';
                $html.= '<i class="fas fa-trash-alt text-danger"></i>';
                $html.= '</a>';
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
}
