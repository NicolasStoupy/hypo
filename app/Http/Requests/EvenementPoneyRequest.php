<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use Illuminate\Foundation\Http\FormRequest;


class EvenementPoneyRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation ()
    {
        CreatedBy::Run($this);
    }
    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     */
    public function rules(): array
    {
        return [
            'evenement_id' => 'required|int|exists:evenements,id', // L'événement doit exister
            'poney_id' => 'required|int|exists:poneys,id',             // Au moins un poney doit être sélectionné

        ];
    }
}
