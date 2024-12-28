<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        CreatedBy::Run($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {

        $clientId = $this->route('client');
        return [
            'nom' => 'required|string|max:50|unique:clients,nom,' . $clientId,
            'email' => 'required|email|max:50|unique:clients,email,' . $clientId,
            'created_by' => 'required|exists:users,id',
        ];
    }
}
