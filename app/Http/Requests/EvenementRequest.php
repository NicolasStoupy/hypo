<?php

namespace App\Http\Requests;

use App\Http\Requests\CommonsRules\CreatedBy;
use App\Models\Evenement;
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

        if (!$this->request->get('_method') == 'PUT') {
            $this->merge(['status_id' => 'PR']);

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
            'evenement_type_id'=>'required|integer|exists:evenement_types,id',
            'date_debut' => [
                'required',
                'date',
                'before:date_fin',
                function($attribute, $value, $fail) {
                    if ($this->checkTimeOverlaping()) {
                        $fail('Il y a un chevauchement d\'événements pour cette période.');
                    }
                }
            ],
        ];
    }

    /**
     * Vérifie si l'événement actuel chevauche un autre événement prévu pour la même journée.
     *
     * Cette méthode parcourt tous les événements programmés pour la même date que l'événement
     * à valider, et vérifie si les plages horaires de l'événement actuel se chevauchent avec celles
     * d'un événement existant. Un chevauchement est détecté si l'une des conditions suivantes est vraie :
     * 1. L'événement actuel commence avant la fin de l'événement existant et se termine après son début.
     * 2. L'événement actuel commence avant la fin de l'événement existant.
     * 3. L'événement actuel finit après le début de l'événement existant.
     * 4. L'événement actuel englobe complètement l'événement existant.
     *
     * Si un chevauchement est trouvé, la méthode retourne `true`. Sinon, elle retourne `false`.
     *
     * @return bool `true` si un chevauchement est trouvé, `false` sinon.
     */
    private function checkTimeOverlaping()
    {
        $overlaps = false; // Initialisation de la variable qui indique si un chevauchement est trouvé
        // Récupérer les événements du même jour
        $evenements_same_day = Evenement::whereDate('date_evenement', $this->date_evenement)
            ->get();

        // Parcourir tous les événements du même jour
        foreach ($evenements_same_day as $evenement) {
            $start = $evenement->date_debut; // Heure de début de l'événement
            $end = $evenement->date_fin; // Heure de fin de l'événement

            // Vérification des chevauchements possibles
            if (
                ($start < $this->date_fin && $end > $this->date_debut) || // L'événement actuel chevauche en partie
                ($start >= $this->date_debut && $start < $this->date_fin) || // L'événement commence avant la fin de l'événement actuel
                ($end > $this->date_debut && $end <= $this->date_fin) || // L'événement finit après le début de l'événement actuel
                ($start <= $this->date_debut && $end >= $this->date_fin) // L'événement actuel englobe l'événement existant
            ) {
                // Si un chevauchement est trouvé, on met $overlaps à true
                $overlaps = true;
                break; // Sortir de la boucle dès qu'on trouve un chevauchement
            }
        }

        // Retourner le résultat final
        return $overlaps; // Retourne true si un chevauchement a été trouvé, false sinon
    }



}
