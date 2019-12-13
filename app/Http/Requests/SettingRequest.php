<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name' => 'required|unique:settings,name,'.Request()->get('id'),
            'value' => 'required',
            'tag' => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Please enter name',
            'name.uinique' => 'The name is exsists already',
            'value.required' => 'Please enter value',
            'tag.required' => 'Please choose tag',
            'tag.numeric' => 'Tag value may be wrong'
        ];
    }
}
