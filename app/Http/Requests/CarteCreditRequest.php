<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CarteCreditRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette demande.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numero' => [
                'required',
                'regex:/^(\d{4}[- ]?){3}\d{4}$/', // Permet les tirets ou espaces
                function ($attribute, $value, $fail) {
                    $numeroSansFormat = str_replace(['-', ' '], '', $value);
                    if (strlen($numeroSansFormat) !== 16) {
                        $fail('Le numéro de la carte doit contenir exactement 16 chiffres.');
                    }
                }
            ],
            'nom_titulaire' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z ]+$/', // Vérifie que le nom contient uniquement des lettres et des espaces
            ],
            'date_expiration' => [
                'required',
                'date_format:Y-m', // Vérifie le format MM/YYYY
                'after_or_equal:' . $this->getPreviousMonth() // Comparer avec le mois précédent
            ],
            'cvc' => 'required|numeric|digits:3',
        ];
    }

    /**
     * Messages d'erreur personnalisés.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'numero.required' => 'Le numéro de carte est obligatoire.',
            'numero.regex' => 'Le numéro de carte doit être formaté correctement (ex: 1234 5678 9101 1121).',
            'numero.digits' => 'Le numéro de la carte doit contenir exactement 16 chiffres.',
            'nom_titulaire.required' => 'Le nom du titulaire est obligatoire.',
            'nom_titulaire.string' => 'Le nom du titulaire doit être une chaîne de caractères valide.',
            'nom_titulaire.max' => 'Le nom du titulaire ne peut pas dépasser 255 caractères.',
            'nom_titulaire.regex' => 'Le nom du titulaire ne doit contenir que des lettres et des espaces.',
            'date_expiration.required' => 'La date d\'expiration est obligatoire.',
            'date_expiration.date_format' => 'Le format de la date d\'expiration doit être MM/YYYY.',
            'date_expiration.after_or_equal' => 'La date d\'expiration doit être supérieure ou égale au mois précédent.',
            'cvc.required' => 'Le code de sécurité CVC est obligatoire.',
            'cvc.numeric' => 'Le code CVC doit être un nombre.',
            'cvc.digits' => 'Le code CVC doit être constitué de 3 chiffres.',
        ];
    }

    /**
     * Retourne le mois précédent au format Y-m.
     *
     * @return string
     */
    protected function getPreviousMonth()
    {
        return Carbon::now()->subMonth()->format('Y-m'); // Format : "YYYY-MM"
    }
}
