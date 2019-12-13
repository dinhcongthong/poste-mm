<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Param;

class BullBoard extends Model
{
	use SoftDeletes;
	
	protected $table = 'bullboards';
	
	protected $dates = ['deleted_at'];
	
	public $fillable = [
		'slug', 'name', 'category_id','address','first_image','second_image',
		'content','email','phone','show_phone_num','user_id','approver_id','start_date','end_date'
	];
	
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
	//
	
	// Static function
	public static function getBullBoardList($getTrashed = false)
	{
		// var_dump($getTrashed);die;
		if($getTrashed) {
			return self::with('getUser')->withTrashed()->get();
		} else {
			return self::with('getUser')->get();
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
		$article = self::withTrashed()->find($id);
		
		if(is_null($article)) {
			return self::create($data);
		}
		
		$article->name = $data['name'];
		$article->slug = $data['slug'];
		$article->category_id = $data['category_id'];
		$article->address = $data['address'];
		$article->start_date = $data['start_date'];
		$article->end_date = $data['end_date'];
		$article->content = $data['content'];
		$article->email = $data['email'];
		$article->phone = $data['phone'];
		$article->show_phone_num = $data['show_phone_num'];

		if(empty($data['pre_image1'])) {
			Gallery::clearGallery($article->first_image, 'bullboard', $article->id);
		}

		if($data['first_image'] != $article->first_image && $data['first_image'] != 0) {
				if($article->first_image != 0) {
					Gallery::clearGallery($article->first_image, 'bullboard', $article->id);
				}
				
				$article->first_image = $data['first_image'];
		}

		if(empty($data['pre_image2'])) {
			Gallery::clearGallery($article->second_image, 'bullboard', $article->id);
		}

		if($data['second_image'] != $article->second_image && $data['second_image'] != 0) {
				if($article->second_image != 0) {
					Gallery::clearGallery($article->second_image, 'bullboard', $article->id);
				}
				
				$article->second_image = $data['second_image'];
		}
		$article->user_id = $data['user_id'];
		
		$article->save();
		
		return $article;
	}
	
	public static function deleteItem($id) {
		$article = self::withTrashed()->find($id);
		
		if(is_null($article)) {
			return [
				'result' => 1,
				'error' => 'Can not find any article'
			];
		}
		
		$gallery = $article->getFirstImage;
		if(!is_null($gallery)) {
			Gallery::clearGallery($gallery->id, 'bullboard', $article->id);
		}
		
		$gallery = $article->getSecondImage;
		if(!is_null($gallery)) {
			Gallery::clearGallery($gallery->id, 'bullboard', $article->id);
		}
		
		$result = $article->forceDelete();
		
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
