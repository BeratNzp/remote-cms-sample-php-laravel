<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            'title' => 'Servis Adı',
            'price' => 'Fiyat',
            'currency_id' => 'Para Birimi',
            'first_payment_time' => 'İlk Ödeme',
            'last_payment_time' => 'Son Ödeme',
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
            'title' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'currency_id' => 'required',
            'first_payment_time' => 'required|date|before_or_equal:last_payment_time|date_format:Y-m-d',
            'last_payment_time' => 'required|date|before_or_equal:today|date_format:Y-m-d',
        ];
    }
}
