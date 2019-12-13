<?php

namespace App\Http\Requests\PosteTown;

use Illuminate\Foundation\Http\FormRequest;

class PDFRequest extends FormRequest
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
            'file' => 'required|max:10240|mimes:pdf'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            'file.required' => "Dont have file",
            'file.max' => 'File size is too large',
            'file.mimes' => 'File type is wrong'
        ];
    }
}
