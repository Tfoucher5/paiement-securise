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
        if (auth()->user()->isA('user'))
        {
            $cartes = CarteCredit::where('user_id', auth()->user()->id)->get();
            return view('paiements.create', compact('cartes'));
        }
    }

    /**
     * Enregistre un nouveau paiement.
     *
     * @param  \App\Http\Requests\PaiementRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaiementRequest $request)
    {
        if (auth()->user()->isA('user'))
        {
            // Protection contre l'injection de balises HTML dans les données sensibles
            $montant = e($request->input('montant'));  // Échappe le montant pour éviter XSS

            // Crée un paiement en associant l'utilisateur connecté
            $paiement = new Paiement;
            $paiement->carte_id = $request['carte_id'];
            $paiement->user_id = auth()->user()->id;
            $paiement->montant = $montant; // Utilise le montant échappé
            $paiement->save();

            return redirect()->route('paiement.index')->with('success', 'Paiement ajouté avec succès');
        }
    }
}
