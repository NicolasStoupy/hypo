<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FactureCavalierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cavalier_id' => 'required|integer|exists:cavaliers,id',
            'evenement_id' => 'required|integer|exists:evenements,id',
            'amount' => 'required|numeric',
        ];
    }
}
