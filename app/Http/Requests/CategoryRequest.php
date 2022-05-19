<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required|unique:categories', //validation Category
            'category_image' => 'required', //validation Category
            'category_image' => 'mimes:jpg,png,jpeg',
            // 'category_image' => 'file|max:1024',
        ];
    }
    public function messages()
    {
        return [
            // Category Message Alert
            'category_name.required' => 'Please Enter Your Name',
            'category_name.unique' => 'Category Name Already Exist',
        ];
    }
}