<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

use App\Models\Param;

class Category extends Model {
    use SoftDeletes;

    protected $table = 'categories';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name', 'slug', 'english_name', 'user_id', 'parent_id', 'icon', 'tag', 'order_number'
    ];

    // Relationship
    public function getParentCategory() {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }

    public function getChildrenCategory() {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function getNews() {
        return $this->hasManyThrough('App\Models\News', 'App\Models\CategoryNews', 'category_id', 'id', 'id', 'news_id');
    }

    public function getIcon() {
        return $this->belongsTo('App\Models\Gallery', 'icon', 'id');
    }

    public function getTag() {
        return $this->belongsTo('App\Models\Param', 'tag', 'id');
    }

    public function getPersonalTradings() {
        return $this->hasMany('App\Models\PersonalTrading', 'category_id', 'id');
    }

    public function getBullboards() {
        return $this->hasMany('App\Models\BullBoard', 'category_id', 'id');
    }

    public function getJobsearchingFromType() {
        return $this->hasMany('App\Models\JobSearching', 'type_id', 'id');
    }

    public function getJobsearchingFromEmployee() {
        return $this->hasMany('App\Models\JobSearching', 'nationality', 'id');
    }

    public function getJobsearchingFromMajor() {
        return $this->hasMany('App\Models\JobSearching', 'category_id', 'id');
    }

    public function getRealEstateFromForm() {
        return $this->hasMany('App\Models\RealEstate', 'category_id', 'id');
    }

    public function getRealEstateFromPrice() {
        return $this->hasMany('App\Models\RealEstate', 'price_id', 'id');
    }
    public function getRealEstateFromBedroom() {
        return $this->hasMany('App\Models\RealEstate', 'bedroom_id', 'id');
    }

    public function getPosteTowns() {
        return $this->hasMany('App\Models\PosteTown', 'category_id', 'id');
    }

    public function getTownsFromCity() {
        return $this->hasMany('App\Models\PosteTown', 'city_id', 'id');
    }

    public function getTownsFromTag() {
        return $this->hasManyThrough('App\Models\PosteTown', 'App\Models\TownTag', 'tag_id', 'id', 'id', 'town_id');
    }

    public function getBusinesses() {
        return $this->hasManyThrough('App\Models\Business', 'App\Models\CategoryBusiness', 'category_id', 'id', 'id', 'business_id');
    }

    // Static function
    public static function getCategoryList($getTrashed = false) {
        if($getTrashed) {
            $list = self::withTrashed()->with(['getTag', 'getIcon']);
        } else {
            $list = self::with(['getIcon', 'getTag']);
        }

        return $list->where('parent_id', 0)->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('order_num', 'desc')->get();
    }

    public static function getSubCategoryList($getTrashed = false) {
        if($getTrashed) {
            $list = self::withTrashed()->with(['getIcon', 'getTag']);
        } else {
            $list = self::with(['getIcon', 'getTag']);
        }

        return $list->where('parent_id', '<>', 0)->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('order_num', 'desc')->get();
    }

    public static function getConditionCategoryList($name = '', $tag = 0, $getTrashed = false) {
        $categoryList = self::with('');

        if(!empty($name)) {
            $categoryList = $categoryList->where('name', 'LIKE', '%'.$name.'%');
        }

        if(is_numeric($tag) && $tag != 0) {
            $categoryList = $categoryList->where('tag', $tag);
        }

        if(is_array($tag) && !empty($tag)) {
            $categoryList = $categoryList->whereIn('tag', $tag);
        }

        if($getTrashed) {
            $categoryList = $categoryList->withTrashed();
        }

        return $categoryList->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('order_num', 'desc')->get();
    }

    public static function getCategoryListFromParam($news_type, $getTrashed = false) {
        $paramList = Param::getExactParamList($news_type, 'category');

        $categoryList = self::with(['getChildrenCategory', 'getIcon'])->whereIn('tag', $paramList);

        if($getTrashed) {
            $categoryList = $categoryList->withTrashed();
        }

        return $categoryList->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('id', 'ASC')->orderBy('order_num', 'desc')->get();
    }

    public static function getBusinessCategoryList() {
        $paramItem = Param::getExactParamItem('business', 'category');

        if(!is_null($paramItem)) {
            $categoryList = self::with(['getChildrenCategory','getChildrenCategory.getBusinesses'])->where('tag', $paramItem->id)->select(DB::raw('*, TIMESTAMPDIFF(DAY, `updated_at`, NOW()) as `datecount`'))->orderBy('order_num', 'desc')->get();

            return $categoryList;
        }
        return false;
    }

    public static function getItem($id, $getTrashed = false) {
        if(!$getTrashed) {
            return self::with('getIcon')->find($id);
        } else {
            return self::with('getIcon')->withTrashed()->find($id);
        }
    }

    public static function createNew($data, $id) {
        $item = self::withTrashed()->find($id);

        if(is_null($item)) {
            return self::create($data);
        }

        $item->name = $data['name'];
        $item->english_name = $data['english_name'];
        $item->slug = $data['slug'];
        $item->tag = $data['tag'];
        $item->order_num = $data['order_num'];
        $item->user_id = $data['user_id'];
        $item->parent_id = $data['parent_id'];
        if($item->icon != $data['icon'] && $data['icon'] != 0) {
            Gallery::deleteFile($item->icon, true);
            $item->icon = $data['icon'];
        }

        return $item->save();
    }

    public static function changeStatus($id) {
        $categoryItem = self::getItem($id, $getTrashed = true);

        if(is_null($categoryItem)) {
            return response()->json(['result' => false]);
        } else {
            if($categoryItem->trashed()) {
                $categoryItem->restore();
                $status = true;
            } else {
                $categoryItem->delete();
                $status = false;
            }

            return response()->json(['result' => true, 'status' => $status]);
        }
    }

    /**
    * Helper function to delete category or subcategory
    *
    * @return Array : The result of deletion
    */
    public function completeRemove() {
        $this->load([
            'getChildrenCategory' => function($query) {
                $query->withTrashed();
            },
            'getNews' => function($query) {
                $query->withTrashed();
            },
            'getPersonalTradings' => function($query) {
                $query->withTrashed();
            },
            'getBullboards' => function($query) {
                $query->withTrashed();
            },
            'getJobsearchingFromType' => function($query) {
                $query->withTrashed();
            },
            'getJobsearchingFromEmployee' => function($query) {
                $query->withTrashed();
            },
            'getJobsearchingFromMajor' => function($query) {
                $query->withTrashed();
            },
            'getRealEstateFromForm' => function($query) {
                $query->withTrashed();
            },
            'getRealEstateFromPrice' => function($query) {
                $query->withTrashed();
            },
            'getRealEstateFromBedroom' => function($query) {
                $query->withTrashed();
            },
            'getPosteTowns' => function($query) {
                $query->withTrashed();
            },
            'getTownsFromCity' => function($query) {
                $query->withTrashed();
            },
            'getTownsFromTag' => function($query) {
                $query->withTrashed();
            },
            'getBusinesses' => function($query) {
                $query->withTrashed();
            },
        ]);

        $data = array();

        if(!$this->getChildrenCategory->isEmpty()) {
            $data[] = 'This category have sub-category.';
        }
        if(!$this->getNews->isEmpty()) {
            $data[] = 'This category was being used for News.';
        }
        if(!$this->getPersonalTradings->isEmpty()) {
            $data[] = 'This category was being used for PersonalTrading.';
        }
        if(!$this->getBullboards->isEmpty()) {
            $data[] = 'This category was being used for Bullboard.';
        }
        if(!$this->getJobsearchingFromType->isEmpty()) {
            $data[] = 'This category was being used for Jobsearching like Type.';
        }
        if(!$this->getJobsearchingFromEmployee->isEmpty()) {
            $data[] = 'This category was being used for Jobsearching like Employee.';
        }
        if(!$this->getJobsearchingFromMajor->isEmpty()) {
            $data[] = 'This category was being used for Jobsearching like Major.';
        }
        if(!$this->getRealEstateFromForm->isEmpty()) {
            $data[] = 'This category was being used for RealEstate like Form.';
        }
        if(!$this->getRealEstateFromPrice->isEmpty()) {
            $data[] = 'This category was being used for RealEstate like Price.';
        }
        if(!$this->getRealEstateFromBedroom->isEmpty()) {
            $data[] = 'This category was being used for RealEstate like Bedroom.';
        }
        if(!$this->getPosteTowns->isEmpty()) {
            $data[] = 'This category was being used for PosteTown like category.';
        }
        if(!$this->getTownsFromCity->isEmpty()) {
            $data[] = 'This category was being used for PosteTown like city.';
        }
        if(!$this->getTownsFromTag->isEmpty()) {
            $data[] = 'This category was being used for PosteTown like tag.';
        }
        if(!$this->getBusinesses->isEmpty()) {
            $data[] = 'This category was being used for Business.';
        }

        if(empty($data)) {
            $this->forceDelete();
        }

        return $data;
    }
}
