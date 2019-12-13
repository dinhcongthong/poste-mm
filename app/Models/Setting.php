<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Param;

class Setting extends Model
{
    protected $table = 'settings';

    public $fillable = [
        'name', 'value', 'tag', 'user_id', 'slug', 'english_value'
    ];

    // Relationship
    public function getTag() {
        return $this->belongsTo('App\Models\Param', 'tag', 'id');
    }

    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // Static functionss
    public static function getList($name = '', $tag = 0) {
        $list = self::with(['getUser', 'getTag']);

        if(!empty($name)) {
            $list = $list->where('name', 'LIKE', $name);
        }

        if(is_numeric($tag) && $tag != 0) {
            return $list->where('tag', $tag)->get();
        }

        if(is_array($tag) && !empty($tag)) {
            return $list->whereIn('tag', $tag)->get();
        }

        return $list->get();
    }

    public static function getSettingListFromParam($news_type) {
        $param = Param::getExactParamItem($news_type, 'setting');

        $settingList = self::where('tag', $param->id);

        return $settingList->get();
    }

    public static function getItem($id) {
        return self::find($id);
    }

    public static function postUpdate($id, $data) {
        $item = self::find($id);

        if(is_null($item)) {
            return self::create($data);
        }

        $item->name = $data['name'];
        $item->value = $data['value'];
        $item->english_value = $data['english_value'];
        $item->tag = $data['tag'];
        $item->slug = $data['slug'];
        $item->user_id = $data['user_id'];

        $item->save();

        return $item;
    }

    public static function deleteItem($id) {
        $item = self::find($id);

        if(is_null($id)) {
            return [
                'result' => 0,
                'error' => 'Can not find any setting'
            ];
        }

        $result = $item->delete();

        if($result) {
            return [
                'result' => 1
            ];
        }
        return [
            'result' => 0,
            'error' => 'Something is wrong'
        ];
    }
}
