<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'published_date' => 'required|date_format:m-d-Y',
            'thumb_url' => 'nullable',
            'thumbnail' => 'nullable|required_without:thumb_url|max:2049|mimes:jpeg,jpg,png'
        ];
    }

    /**
     * Get the validation mesages that apply to the request
     * 
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Please enter the movie name',
            'description.required' => 'Please enter the movie description',
            'published_date.required' => 'Please enter the movie\'s release date',
            'thumbnail.required_without' => 'Please choose image for movie',
            'thumbnail.max' => 'Image size is too large',
            'thumbnail.mimes' => 'Image file type is wrong'
        ];
    }
}
