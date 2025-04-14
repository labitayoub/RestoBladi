<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
            "table_id" => "required|array",
            "table_id.*" => "exists:tables,id",
            "menu_id" => "required|array",
            "menu_id.*" => "exists:menus,id",
            "total_ht" => "required|numeric",
            "tva" => "required|numeric",
            "total_ttc" => "required|numeric",
            "payment_type" => "required|in:cash,card",
            "waiter_id" => "required|exists:waiters,id",
        ];
    }
}
