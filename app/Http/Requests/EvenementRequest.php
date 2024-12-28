<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use Illuminate\Foundation\Http\FormRequest;

class EvenementRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prix' => 'required|numeric|min:0', // Le prix doit être un nombre positif
            'nombre_participant' => 'required|integer|min:1', // Au moins un participant
            'date_debut' => 'required|date|before:date_fin', // La date de début doit être avant la date de fin
            'date_fin' => 'required|date|after:date_debut', // La date de fin doit être après la date de début
            'client_id' => 'required|exists:clients,id', // Le client doit exister dans la table 'clients'
            'facture_id' => 'nullable|exists:factures,id', // Si fourni, la facture doit exister dans la table 'factures'
            'created_by' => 'required|exists:users,id', // L'utilisateur créant l'événement doit exister
        ];
    }

}
