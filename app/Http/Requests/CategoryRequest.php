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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $categoryId = $this->route('category')?->id ?? null;
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'This category name is already in use.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Please upload a valid image (jpg, jpeg, png, webp).',
            'image.max' => 'The image must not be larger than 2MB.',
        ];
    }
}
