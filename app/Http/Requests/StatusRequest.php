<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        // Retourner true si l'utilisateur est autorisé à faire cette requête, sinon false
        return true; // Changer en fonction de la logique d'autorisation (authentification, rôles, etc.)
    }

    /**
     * Obtenir les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $status_id = $this->route('id');
        return [
            'id' => 'required|string|size:2|unique:status,' . $status_id, // L'id doit être requis, de type string, de taille 2 et unique dans la table 'status'
            'description' => 'required|string|max:255', // La description est requise et de type string, avec un maximum de 255 caractères
        ];
    }

}
