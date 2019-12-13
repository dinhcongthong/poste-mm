<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            'post_id'       => 'required|numeric',
            'email'         => 'required|email|max:191',
            'name'          => 'required|string|max:191',
            'content'       => 'required'
        ];
    }

    /**
    * Get the validation messages that apply to the request
    *
    * @return array
    */
    public function messages() {
        return [
            'post_id.required'      => 'Invalid Post id',
            'post_id.numeric'       => 'Invalid Post id',
            'email.required'        => 'Please enter email',
            'email.email'           => 'Email is invalid',
            'email.max'             => 'Email is invalid length',
            'name.required'         => 'Please enter name',
            'name.string'           => 'Name is invalid',
            'name.max'              => 'Name is invalid length',
            'post_type.required'    => 'Post type is invalid',
            'content.required'      => 'Content is required'
        ];
    }
}
