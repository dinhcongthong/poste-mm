<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'keywords' => 'required',
            'customer_id' => 'required|numeric',
            'category_ids' => 'required|array',
            'city_id' => 'required|numeric',
            'thumb_url' => 'nullable',
            'image' => 'nullable|required_without:thumb_url|mimes:jpeg,png,jpg|max:2049|dimensions:min_width=600,ratio=4/3',
            'description' => 'required|string|max:191',
            'title_content' => 'nullable',
            'content.0' => 'required',
            'start_date' => 'nullable|date_format:m-d-Y',
            'end_date' => 'nullable|date_format:m-d-Y|after_or_equal:start_date',
            'published_at' => 'required|date_format:m-d-Y',
            'status' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the request
     *
     * @return array
    */
    public function messages() {
        return [
            'name.required' => 'Name can not empty',
            'keywords.required' => 'Keywords can not empty',
            'customer_id.required' => 'Customer must be chosen',
            'customer_id.numeric' => 'Customer value is wrong',
            'category_ids.required' => 'Category must be chosen',
            'category_ids.array' => 'Category is wrong',
            'city_id.required' => 'City must be chosen',
            'city_id.numeric' => 'City value is wrong',
            'image.required_without' => 'Please choose image',
            'image.mimes' => 'Image type is wrong',
            'image.max' => 'Image size is too big',
            'image.dimensions' => 'Image ratio or size are wrong',
            'description.required' => 'Description can not empty',
            'description.string' => 'Description must be string',
            'description.max' => 'Description is too long',
            'content.0.required' => 'Content can not empty',
            'start_date.date_format' => 'Start date format is wrong',
            'end_date.date_format' => 'End date format is wrong',
            'end_date.after_or_equal' => 'End date is wrong',
            'published_at.required' => 'Published date can not empty',
            'published_at.date_format' => 'Published date format is wrong',
            'status.required' => 'Please choose status'
        ];
    }
}
