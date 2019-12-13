<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GolfRequest extends FormRequest
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
            'description' => 'required',
            'address' => 'required',
            'district_id' => 'nullable|numeric',
            'city_id' => 'required|numeric',
            'website' => 'active_url|nullable',
            'thumb_url' => 'nullable',
            'image' => 'nullable|required_without:thumb_url|mimes:jpeg,jpg,png|max:2049|dimensions:min_width=600px,ratio=4/3',
            'status' => 'required|numeric',
            'work_time' => 'required',
            'phone' => 'required'
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
            'description.required' => 'Description can not empty',
            'address.required' => 'Address can not empty',
            'district_id.required' => 'Please choose a district',
            'district_id.numeric' => 'District value is wrong',
            'city_id.required' => 'Please choose a city',
            'city_id.numeric' => 'City value is wrong',
            'website.active_url' => 'URL of website was die',
            'image.required_without' => 'Please choose Thumnail',
            'image.mimes' => 'Thumbnail Image file type is wrong',
            'image.max' => 'Thumbnail image size is too large',
            'image.dimensions' => 'Thumbnail ratio or min width is wrong',
            'work_time.required' => 'Work time can not empty',
            'status.required' => 'Please choose status',
            'status.numeric' => 'Status value is wrong',
            'phone.required' => 'Please enter Phone Number'
        ];
    }
}
