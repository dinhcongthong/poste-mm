<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'category_ids'  => 'required',
            'avatar'        => 'required_without:avatar_url|image|max:4097|dimensions:min_width=300',
            'name'          => 'required|max:191',
            'description'   => 'required',
            'email'         => 'nullable|email|max:191',
            'phone'         => 'nullable|max:191',
            // 'pdf_url'       => 'nullable|active_url',
            'gallery_id.*'  => 'nullable|numeric'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_ids.required'     => 'Please choose Category',
            'avatar.required_without'           => 'Please choose Thumbnail Image',
            'avatar.image'              => 'Choosen file is not image',
            'avatar.max'                => 'Image size is too large',
            'avatar.dimesion'           => 'Image\'s too small',
            'name.required'             => 'Please enter name',
            'name.max'                  => 'Name is too long',
            'description.required'      => 'Please enter Description',
            'email.email'               => 'Email is wrong',
            'email.max'                 => 'Email is too long',
            'phone.max'                 => 'Phone is too long',
            'pdf_url.active_url'        => 'PDF File Input error',
            'gallery_id.*.numeric'      => 'Value of gallery is wrong'
        ];
    }
}
