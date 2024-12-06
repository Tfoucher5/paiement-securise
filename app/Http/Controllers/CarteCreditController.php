<?php

namespace App\Http\Controllers;

use App\Models\CarteCredit;
use App\Http\Requests\CarteCreditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteCreditController extends Controller
{
    /**
     * Display a listing of the user's credit cards.
     */
    public function index()
    {
        if (auth()->user()->isA('admin')) {
            $cartes = CarteCredit::withTrashed()->orderBy('created_at', 'desc')->get();
            return view('cartes.index', compact('cartes'));
        } else {
            $cartes = CarteCredit::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
            return view('cartes.index', compact('cartes'));
        }
    }

    /**
     * Show the form for creating a new credit card.
     */
    public function create()
    {
        if (auth()->user()->isA('user'))
        {
            return view('cartes.create');
        } else
        {
            return redirect()->route('carte-credit.index')->with('error', 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
        }
    }

    /**
     * Store a newly created credit card in storage.
     */
    public function store(CarteCreditRequest $request)
    {
        if (auth()->user()->isA('user'))
        {
            $validatedData = $request->validated();

            $numero = str_replace(['-', ' '], '', $validatedData['numero']);

            $dateExpiration = \Carbon\Carbon::createFromFormat('Y-m', $validatedData['date_expiration'])->format('m/y');

            // Nettoyage des champs texte pour empêcher les balises HTML et XSS
            $nomTitulaire = e($validatedData['nom_titulaire']); // Échappe le nom du titulaire pour éviter XSS
            $cvc = $validatedData['cvc'];

            $carte = new CarteCredit;
            $carte->user_id = auth()->user()->id;
            $carte->numero = $numero;
            $carte->nom_titulaire = $nomTitulaire; // Stocke le nom du titulaire échappé
            $carte->date_expiration = $dateExpiration;
            $carte->cvc = $cvc;
            $carte->save();

            return redirect()->route('carte-credit.index')->with('success', 'Carte de crédit ajoutée avec succès.');
        } else
        {
            return redirect()->route('carte-credit.index')->with('error', 'Vous n\'avez pas l\'autorisation de faire cela.');
        }

    }

    /**
     * Remove the specified credit card from storage.
     */
    public function destroy(CarteCredit $carteCredit)
    {
        $carteCredit->delete();

        return redirect()->route('carte-credit.index')->with('success', 'Carte de crédit supprimée avec succès.');

    }
}
