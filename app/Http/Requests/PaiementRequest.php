<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaiementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'carte_id' => 'required|exists:carte_credits,id',
            'montant' => 'required|numeric|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            'carte_id.required' => 'Veuillez sélectionner une carte.',
            'montant.required' => 'Veuillez entrer un montant.',
        ];
    }
}
