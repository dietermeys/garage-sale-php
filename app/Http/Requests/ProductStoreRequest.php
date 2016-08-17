<?php

namespace App\Http\Requests;


class ProductStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'summary' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|max:4096',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
