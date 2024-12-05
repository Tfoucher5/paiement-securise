<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\CarteCredit;
use Illuminate\Http\Request;
use App\Http\Requests\PaiementRequest;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    // Déplacer le middleware dans le constructeur
    public function __construct()
    {
        auth()->check();
    }

    public function index()
    {
        if (auth()->user()->isA('admin')) {
            $paiements = Paiement::all();
            return view('paiements.index', compact('paiements'));
        } else {
            $paiements = Paiement::where('user_id', Auth::id())->get();
            return view('paiements.index', compact('paiements'));
        }
    }


    public function create()
    {
        $cartes = CarteCredit::where('user_id', auth()->user()->id)->get();
        return view('paiements.create', compact('cartes'));
    }

    /**
     * Enregistre un nouveau paiement.
     *
     * @param  \App\Http\Requests\PaiementRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaiementRequest $request)
    {
        // Crée un paiement en associant l'utilisateur connecté
        $paiement = new Paiement;
        $paiement->carte_id = $request['carte_id'];
        $paiement->user_id = auth()->user()->id;
        $paiement->montant = $request['montant'];
        $paiement->save();

        return redirect()->route('paiement.index')->with('success', 'Paiement ajouté avec succès');
    }


    // // Gérer un remboursement
    // public function rembourserPaiement($id)
    // {
    //     $paiement = Paiement::findOrFail($id);

    //     // Si l'utilisateur est un administrateur, il peut rembourser tout paiement
    //     if (auth()->user()->isA('admin')) {
    //         return redirect()->route('paiements.index')->with('error', 'Vous n\'avez pas la permission de rembourser ce paiement.');
    //     }

    //     // Logique pour rembourser le paiement (par exemple, marquer comme remboursé ou supprimer)
    //     $paiement->delete();

    //     return redirect()->route('paiements.index')->with('success', 'Remboursement effectué avec succès.');
    // }
}
