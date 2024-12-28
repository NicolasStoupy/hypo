<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use Illuminate\Foundation\Http\FormRequest;

class PoneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        // Add 'created_by' to the request before validation
        CreatedBy::Run($this);

    }

    public function rules(): array
    {

        $poneyId = $this->route('poney');

        return [
            'nom' => [
                'required',
                'unique:poneys,nom,' . $poneyId, // Exclure l'enregistrement actuel de la vérification
            ],
            'max_hour_by_day' => 'required|integer|max:24',
            'created_by' => 'required|exists:users,id',
        ];
    }


    /**
     * Get custom attribute names.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'nom' => 'Poney name',
            'max_hour_by_day' => 'Max hours per day',
            'created_by' => 'Created by',
        ];
    }


}
