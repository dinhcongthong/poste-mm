<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JobSearching extends Model
{
    use SoftDeletes;

    const PARAM_TYPE_ID = 23;
    const PARAM_EMPLOYEE_ID = 22;
    const PARAM_MAJOR_ID = 21;

	protected $table = 'jobsearchings';

	protected $dates = ['deleted_at'];

	public $fillable = [
		'slug', 'name', 'type_id', 'category_id', 'quantity', 'nationality', 'address',
		'content','requirement','salary','other_info','email','phone','show_phone_num','user_id','approver_id'
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
	public function type()
	{
		return $this->belongsTo('App\Models\Category', 'type_id', 'id');
	}

	/**
	* Relationship n - 1
	*/
	public function getNationality()
	{
		return $this->belongsTo('App\Models\Category', 'nationality', 'id');
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
	public static function getJobSearchingsList($getTrashed = false)
	{
		if($getTrashed) {
			return self::with('getUser')->withTrashed()->get();
		} else {
			return self::with('getUser')->get();
		}
	}

	public static function updateStatus($id) {
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

	public static function deleteItem($id)
	{
		$article = self::withTrashed()->find($id);

		if (is_null($article)) {
			return [
				'result' => 1,
				'error' => 'Can not find any article'
			];
		}

		$result = $article->forceDelete();

		if ($result) {
			return [
				'result' => 1
			];
		}

		return [
			'result' => 0,
			'error' => 'Something is wrong'
		];
	}

	public static function updateItem($id, $data) {
		$article = self::withTrashed()->find($id);

		if(is_null($article)) {
			return self::create($data);
		}

		$article->name = $data['name'];
		$article->slug = $data['slug'];
		$article->type_id = $data['type_id'];
		$article->category_id = $data['category_id'];
		$article->nationality = $data['nationality'];
		$article->quantity = $data['quantity'];
		$article->content = $data['content'];
		$article->phone = $data['phone'];
		$article->email = $data['email'];
		$article->show_phone_num = $data['show_phone_num'];
		$article->address = $data['address'];
		$article->requirement = $data['requirement'];
		$article->other_info = $data['other_info'];
		$article->salary = $data['salary'];

		$article->save();

		return $article;
	}
}
