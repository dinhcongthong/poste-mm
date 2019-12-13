<?php

namespace App\Http\Requests\PosteTown;

use Illuminate\Foundation\Http\FormRequest;

class TownBasicInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar'        => 'required_without:avatar_url|mimes:jpg,png,jpeg|max:2049',
            'name'          => 'required|string|max:191',
            'city_id'       => 'required|numeric',
            'address'       => 'required|string|max:191',
            'description'   => 'required|string',
            'category_id'   => 'required|numeric'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     * 
     * @return array
     */
    public function messages() {
        return [
            'avatar.required_without'       => 'サムネイル画像を選択してください（The avatar is required. Please choose image file）',
            'avatar.mimes'                  => 'Avatar file extension is not correct. Please use jpg, jpeg or png file.',
            'avatar.max'                    => 'Avatar file size is too large. Please use image maximum file size is 2MB',
            'name.required'                 => '店名を記入してください（Store name can not be empty）',
            'name.string'                   => 'Store name must be string',
            'name.max'                      => 'Store name is too long',
            'city_id.required'              => '都市を選択してください（Please choose city）',
            'city_id.numeric'               => 'City value is wrong',
            'address.required'              => '住所を記入してください（Address can not be empty）',
            'address.string'                => 'Address must be string',
            'address.max'                   => 'Address is too long',
            'description.required'          => '概要欄を記入してください（Description can not be empty）',
            'description.string'            => 'Description must be string',
            'category_id.required'          => 'Category can not be empty',
            'category_id.numeric'           => 'Category value is wrong'
        ];
    }
}
