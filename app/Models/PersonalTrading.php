<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;

class PersonalTrading extends Model
{

    use SoftDeletes;

    const PARAM_CATEGORY_ID = 15;
    const PARAM_TYPE_ID = 16;
    const PARAM_DELIVERY_ID = 17;

	protected $table = 'personaltradings';

	protected $dates = ['deleted_at'];

	public $fillable = [
		'slug', 'name', 'type_id', 'category_id', 'price', 'delivery_method', 'user_id','content','address',
		'first_image','second_image','phone','email','show_phone_num','user_id','approver_id'
	];


	/**
	* Relationship n - 1
	*/
	public function type()
	{
		return $this->belongsTo('App\Models\Setting', 'type_id', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function delivery()
	{
		return $this->belongsTo('App\Models\Setting', 'delivery_method', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function category()
	{
		return $this->belongsTo('App\Models\Category', 'category_id', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function getFirstImage()
	{
		return $this->belongsTo('App\Models\Gallery', 'first_image', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function getSecondImage()
	{
		return $this->belongsTo('App\Models\Gallery', 'second_image', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function getUser()
	{
		return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function approver()
	{
		return $this->belongsTo('App\Models\User', 'approver_id', 'id');
	}


	// Static function
	public static function getPersonalTradingList($getTrashed = false)
	{
		if($getTrashed) {
			return self::with(['type', 'category'])->withTrashed()->orderBy('updated_at', 'DESC')->get();
		} else {
			return self::with(['type', 'category'])->orderBy('updated_at', 'DESC')->get();
		}
	}
	public static function updateStatus($id)
	{
		$item = self::withTrashed()->find($id);

		if(is_null($item)) {
			return response()->json(['result' => 0, 'error' => 'Don\'t find any item']);
		}

		if($item->trashed()) {
			$item->restore();
			$status = 1;
		} else {
			$item->delete();
			$status = 0;
		}

		return response()->json(['result' => 1, 'status' => $status]);
	}

	public static function getItem($id, $getTrashed = false) {
		$item = self::with(['getFirstImage', 'getSecondImage', 'type', 'category']);
		if($getTrashed) {
			return $item->withTrashed()->find($id);
		} else {
			return $item->find($id);
		}
	}

	public static function getListByUserId($userId = 0, $paginateLimit = 0, $getTrashed = false)
	{
		if($getTrashed) {
			$articleList = self::withTrashed()->where('user_id', $userId)->orderBy('updated_at', 'DESC');
		} else {
			$articleList = self::where('user_id', $userId)->orderBy('updated_at', 'DESC');
		}

		if($paginateLimit != 0) {
			return $articleList->paginate($paginateLimit);
		}

		return $articleList->get();
	}

	public static function updateItem($id, $data) {
		$item = self::withTrashed()->find($id);

		if(is_null($item)) {
			return self::create($data);

		}

		$item->type_id = $data['type_id'];
		$item->category_id = $data['category_id'];
		$item->name = $data['name'];
		$item->slug = $data['slug'];
		$item->price = $data['price'];
		$item->delivery_method = $data['delivery_method'];
		$item->content = $data['content'];
		$item->address = $data['address'];

		if(empty($data['pre_image1'])) {
			Gallery::clearGallery($item->first_image, 'personal-trading', $item->id);
		}

		if($item->first_image != $data['first_image'] && $data['first_image'] != 0) {
				if($item->first_image != 0) {
					Gallery::clearGallery($item->first_image, 'personal-trading', $item->id);
				}
				$item->first_image = $data['first_image'];
		}

		if(empty($data['pre_image2'])) {
			Gallery::clearGallery($item->second_image, 'personal-trading', $item->id);
		}

		if($item->second_image != $data['second_image'] && $data['second_image'] != 0) {
				if($item->second_image != 0) {
					Gallery::clearGallery($item->second_image, 'personal-trading', $item->id);
				}
				$item->second_image = $data['second_image'];
		}

		$item->phone = $data['phone'];
		$item->email = $data['email'];
		$item->show_phone_num = $data['show_phone_num'];
		$item->user_id = $data['user_id'];

		$item->save();

		return $item;
	}

	public static function deleteItem($id) {
		$article = self::withTrashed()->find($id);

		if(is_null($article || $article->user_id != Auth::user()->id)) {
			return [
				'result' => false,
				'error' => 'Can not find article'
			];
		}

		$gallery1 = $article->getFirstImage;

		if(!is_null($gallery1)) {
			Gallery::clearGallery($article->first_image, 'personal-trading', $id);
		}

		$gallery2 = $article->getSecondImage;

		if(!is_null($gallery2)) {
			Gallery::clearGallery($article->second_image, 'personal-trading', $id);
		}

		$article->forceDelete();

		return ['result' => true];
	}
}
