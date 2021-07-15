<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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

    public function attributes()
    {
        return [
            'up_category_id' => 'Üst Kategori',
            'type_id' => 'Kategori Tipi',
            'title' => 'Başlık',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'up_category_id' => '',
            'type_id' => 'required',
            'title' => 'required',
        ];
    }
}
