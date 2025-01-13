<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

/**
 * Permet de définir les règles de validation de la demande d'événement.
 */
class EvenementRequest extends FormRequest
{

    /**
     * Déterminez si l'utilisateur est autorisé à effectuer cette demande.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prépare les données pour la validation en utilisant 'CreatedBy'.
     */
    public function prepareForValidation()
    {
        CreatedBy::Run($this);
        if ($this->has('date_debut')) {
            $date_formated = Carbon::parse($this->date_debut)->format('Y-m-d');
            $this->merge(['date_evenement' => $date_formated]);
        }

        if(!$this->request->get('_method') == 'PUT') {
            $this->merge(['status_id' => 'PR'] );

        }


    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
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
            'nom' => 'required|string',
            'date_evenement' => 'required|date',
            'status_id'=>'required|string',
            'evenement_type_id'=>'required|integer|exists:evenement_types,id'
        ];
    }

}
