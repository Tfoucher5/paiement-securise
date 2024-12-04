<?php
namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $utilisateur = $request->user();

        // Vérifie si l'utilisateur est administrateur
        if ($utilisateur->can('voir-tous-les-paiements')) {
            $paiements = Paiement::all(['montant', 'numero_carte', 'expiration_carte', 'created_at']);
        } else {
            $paiements = $utilisateur->paiements()->get(['montant', 'numero_carte', 'expiration_carte', 'created_at']);
        }

        return $paiements->map(function ($paiement) use ($utilisateur) {
            $numeroCarte = $utilisateur->can('voir-numero-complet')
                ? $paiement->numero_carte
                : substr($paiement->numero_carte, 0, 4) . ' **** **** ' . substr($paiement->numero_carte, -4);

            return [
                'montant' => $paiement->montant,
                'numero_carte' => $numeroCarte,
                'expiration_carte' => $paiement->expiration_carte,
                'date' => $paiement->created_at,
            ];
        });
    }

    public function enregistrer(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'numero_carte' => 'required|string|size:16',
            'expiration_carte' => 'required|date_format:m/y',
            'cvc_carte' => 'required|string|size:3',
        ]);

        $paiement = Paiement::create([
            'utilisateur_id' => $request->user()->id,
            'montant' => $request->montant,
            'numero_carte' => $request->numero_carte,
            'expiration_carte' => $request->expiration_carte,
            'cvc_carte' => $request->cvc_carte,
        ]);

        return response()->json($paiement, 201);
    }
}
