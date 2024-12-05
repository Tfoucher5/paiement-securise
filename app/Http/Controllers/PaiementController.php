<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    // Déplacer le middleware dans le constructeur
    public function __construct()
    {
        auth()->check();
    }

    // Enregistrer un paiement
    public function enregistrerPaiement(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'carte_4_premiers' => 'required|string|size:4',
            'carte_4_derniers' => 'required|string|size:4',
            'date_expiration' => 'required|date',
            'num_transaction' => 'required|string|unique:paiements',
        ]);

        $paiement = Paiement::create([
            'user_id' => Auth::id(),
            'montant' => $request->montant,
            'carte_4_premiers' => $request->carte_4_premiers,
            'carte_4_derniers' => $request->carte_4_derniers,
            'date_expiration' => $request->date_expiration,
            'num_transaction' => $request->num_transaction,
        ]);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }

    // Afficher les paiements de l'utilisateur connecté
    public function afficherPaiements()
    {
        $paiements = Paiement::where('user_id', Auth::id())->get();

        return view('paiements.index', compact('paiements'));
    }

    // Gérer un remboursement
    public function rembourserPaiement($id)
    {
        $paiement = Paiement::findOrFail($id);

        // Si l'utilisateur est un administrateur, il peut rembourser tout paiement
        if (auth()->user()->isA('admin')) {
            return redirect()->route('paiements.index')->with('error', 'Vous n\'avez pas la permission de rembourser ce paiement.');
        }

        // Logique pour rembourser le paiement (par exemple, marquer comme remboursé ou supprimer)
        $paiement->delete();

        return redirect()->route('paiements.index')->with('success', 'Remboursement effectué avec succès.');
    }
}
