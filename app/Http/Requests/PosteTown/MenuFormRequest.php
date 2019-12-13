<?php

namespace App\Http\Requests\PosteTown;

use Illuminate\Foundation\Http\FormRequest;

class MenuFormRequest extends FormRequest
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
            'imgFoods.*' => 'nullable|mimes:jpg,jpeg,png|image|size:2097|dimensions:min_width=300',
            'food_name.*' => 'required|string|max:191'
        ];
    }

    public function messages()
    {
        return [
            'imgFoods.*.mimes'      => 'Image Food file type is wrong',
            'imgFoods.*.image'      => 'Image Food file is not image',
            'imgFoods.*.size'       => 'Image Food file is too large',
            'imgFoods.*.dimensions' => 'Image width is too small',
            'food_name.*.required'  => 'Food\'s name can not be empty',
            'food_name.*.string'    => 'Food\'s name must be string',
            'food_name.*.max'       => 'Food\'s name is too long'
        ];
    }
}
