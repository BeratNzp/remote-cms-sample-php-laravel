<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatabaseUpdateRequest extends FormRequest
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
            'company_id' => 'Şirket',
            'ip' => 'IP',
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
            'company_id' => 'required',
            'ip' => 'required',
            'port' => 'required|min:1|max:5',
            'username' => 'required',
            'password' => 'required',
            'database' => 'required',
        ];
    }
}
