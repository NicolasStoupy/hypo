<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class EvenementPoneyRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
