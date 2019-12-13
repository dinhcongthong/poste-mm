<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobSearchingRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'category_id' => 'required|numeric',
            'nationality_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'salary' => 'required',
            'city_id' => 'numeric',
            'address' => 'required',
            'email' => 'nullable|email|max:191',
            'show_phone_num' => 'numeric|nullable',
            'accept' => 'required|numeric'
        ];
    }

    /**
     * Get the validation messages that apply to the request 
     * 
     * @return array 
     */
    public function messages()
    {
        return [
            'name.required' => 'Trading name is required',
            'name.string' => 'Trading name must be string',
            'name.max' => 'Trading name is too long',
            'category_id.required' => 'Please choose category',
            'category_id.numeric' => 'Category value is wrong',
            'type_id.required' => 'Please choose type',
            'type_id.numeric' => 'Type value is wrong',
            'nationality_id.required' => 'Please choose nationality',
            'nationality_id.numeric' => 'Nationality value is wrong',
            'quantity.required' => 'Please enter quantity',
            'quantity.numeric' => 'Quanity must be number',
            'salary.required' => 'Please enter salary',
            'city_id.numeric' => 'City value is wrong',
            'address.required' => 'Please enter address',
            'email.email' => 'Email is wrong',
            'email.max' => 'Email is too long',
            'show_phone_num.numeric' => 'Please choose show phone option again',
            'accept.required' => 'Please accept to term',
            'accept.numeric' => 'Something is wrong'
        ];
    }
}
