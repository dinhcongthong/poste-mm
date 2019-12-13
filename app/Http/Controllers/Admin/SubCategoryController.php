<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\SubCategoryRequest;

use App\Models\Category;
use App\Models\Param;
use App\Models\Base;
use App\Models\Gallery;
use App\Models\ImageFactory;

class SubCategoryController extends Controller
{
    public function index() {
        // $subCategoryList = Category::getSubCategoryList($getTrashed = true);

        // $this->data['subCategoryList'] = $subCategoryList;

        return view('admin.pages.sub-category.index')->with($this->data);
    }

    public function getUpdate($id = 0) {
        $galleryTags = Param::getSubCategoryParam();
        $subCategoryItem = Category::getItem($id, $getTrashed = true);
        $categoryList = [];

        if(!is_null($subCategoryItem)) {
            $tagItem = Param::getParamItem($subCategoryItem->tag);

            $id = $subCategoryItem->id;
            $name = $subCategoryItem->name;
            $english_name = $subCategoryItem->english_name;
            $slug = $subCategoryItem->slug;
            $orderNum = $subCategoryItem->order_num;
            $tag = $subCategoryItem->tag;
            $parentId = $subCategoryItem->parent_id;
            $icon = $subCategoryItem->getIcon ? Base::getUploadURL($subCategoryItem->getIcon->name, $subCategoryItem->getIcon->dir) : '';
        } else {
            $id = 0;
            $name = '';
            $english_name = '';
            $slug = '';
            $tag = 0;
            $orderNum = 0;
            $parentId = 0;
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
        if(old('order_num')) {
            $orderNum = old('order_num');
        }
        if(old('icon')) {
            $icon = old('icon');
        }
        if(old('parent_id')) {
            $parentId = old('parent_id');
        }

        $this->data['id'] = $id;
        $this->data['name'] = $name;
        $this->data['english_name'] = $english_name;
        $this->data['slug'] = $slug;
        $this->data['tag'] = $tag;
        $this->data['orderNum'] = $orderNum;
        $this->data['parentId'] = $parentId;
        $this->data['icon'] = $icon;

        $this->data['galleryTags'] = $galleryTags;
        $this->data['categoryList'] = $categoryList;

        return view('admin.pages.sub-category.update')->with($this->data);
    }

    public function postUpdate(SubCategoryRequest $request, $id = 0) {

        $galleryId = 0;
        if($request->hasFile('icon')) {
            $file = $request->icon;

            if(!is_null($file)) {
                $gallery_id_arr = Gallery::uploadImage(array($file), 'category', 'icon', 'icon');
                $galleryId = $gallery_id_arr[0];
            }
        }

        $slug = $request->slug;
        if(empty($slug)) {
            $slug = $request->name;
        }
        $slug = str_slug($slug, '-');

        $data = array(
            'name' => $request->name,
            'english_name' => $request->english_name,
            'slug' => $slug,
            'tag' => $request->tag,
            'order_num' => $request->order_num,
            'icon' => $galleryId,
            'user_id' => Auth::user()->id,
            'parent_id' => $request->parent_id
        );

        $result = Category::createNew($data, $id);
        if($result) {
            return redirect()->route('get_sub_category_index_ad_route');
        }
    }

    public function changeStatus(Request $request) {
        $id = $request->id;

        return Category::changeStatus($id);
    }

    public function getParentFromNewsType(Request $request) {
        $paramSubCateId = $request->tagId;

        $categoryList = Category::where('parent_id', 0)->where('tag', $paramSubCateId)->orderBy('name', 'ASC')->get();

        return $categoryList;

        $html = '<option value="">Please choose Parent Category</option>';

        foreach($categoryList as $item) {
            $html .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }

        return response()->json(['result' => 1, 'view' => $html]);
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
                        2 => 'parent',
                        3 => 'tag',
                        4 => 'status',
                        5 => 'action'
                    );

                    $totalData = Category::withTrashed()->where('parent_id', '<>', 0)->count();

                    $totalFiltered = $totalData;

                    $limit = $request->length;
                    $start = $request->start;
                    $order = $columns[$request->input('order.0.column')];
                    $dir = $request->input('order.0.dir');

                    if(empty($request->input('search.value'))) {
                        $category_list = Category::withTrashed()->with(['getTag', 'getParentCategory'])->where('parent_id', '<>', 0)->offset($start)->limit($limit)->orderBy($order, $dir)->get();
                    } else {
                        $search = $request->input('search.value');

                        $category_list =  Category::withTrashed()->with(['getTag', 'getParentCategory'])->where('parent_id', '<>', 0)->where('id','LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhereHas('getTag', function($query) use($search) {
                            $query->where('news_type', 'LIKE', "%{$search}%");
                        })->offset($start)->limit($limit)
                        ->orderBy($order, $dir)->get();

                        $totalFiltered = Category::withTrashed()->with(['getTag', 'getParentCategory'])->where('parent_id', '<>', 0)->where('id','LIKE',"%{$search}%")
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
                            $nestedData['parent'] = $category->getParentCategory->name;
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
