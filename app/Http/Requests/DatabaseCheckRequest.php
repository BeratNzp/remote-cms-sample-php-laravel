<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatabaseCheckRequest extends FormRequest
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
            'ipv4' => 'IPv4',
            'port' => 'Port',
            'username' => 'Kullanıcı Adı',
            'password' => 'Parola',
            'database' => 'Veritabanı',
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
            'ipv4' => 'required|ipv4',
            'port' => 'required|integer|between:1024,65535',
            'username' => 'required',
            'password' => 'required',
            'database' => 'required',
        ];
    }
}
