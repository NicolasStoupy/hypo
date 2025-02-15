<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeeklyOpeningHoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'week_number' => 'required|integer|min:1|max:52',  // Valide le numéro de la semaine
            'year' => 'required|integer',  // Valide l'année
            'hours' => 'required|array',  // Valide que les heures sont un tableau
            'hours.*.open_time' => 'nullable|date_format:H:i',  // Valide le format de l'heure d'ouverture
            'hours.*.close_time' => 'nullable|date_format:H:i|after:hours.*.open_time',  // Valide le format de l'heure de fermeture
            'hours.*.is_closed' => 'nullable|boolean',  // Valide si le jour est fermé
        ];
    }

    /**
     * Messages personnalisés pour la validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'week_number.required' => 'Le numéro de semaine est requis.',
            'year.required' => 'L\'année est requise.',
            'hours.required' => 'Les horaires sont requis.',
            'hours.*.open_time.date_format' => 'Le format de l\'heure d\'ouverture est invalide.',
            'hours.*.close_time.date_format' => 'Le format de l\'heure de fermeture est invalide.',
            'hours.*.close_time.after' => 'L\'heure de fermeture doit être après l\'heure d\'ouverture.',
        ];
    }
}
