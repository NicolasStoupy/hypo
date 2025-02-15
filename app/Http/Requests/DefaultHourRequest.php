<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefaultHourRequest extends FormRequest
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
            'default_open_time' => 'required|date_format:H:i',  // Format d'heure valide
            'default_close_time' => 'required|date_format:H:i|after:default_open_time',  // Doit être après l'heure d'ouverture
            'week_number' => 'required|integer|min:1|max:52',  // Assure que la semaine est valide
            'year' => 'required|integer|digits:4|before_or_equal:' . now()->year,  // L'année doit être valide
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
            'default_open_time.required' => 'L\'heure d\'ouverture est requise.',
            'default_close_time.required' => 'L\'heure de fermeture est requise.',
            'default_close_time.after' => 'L\'heure de fermeture doit être après l\'heure d\'ouverture.',
            'week_number.required' => 'Le numéro de semaine est requis.',
            'year.required' => 'L\'année est requise.',
        ];
    }
}
