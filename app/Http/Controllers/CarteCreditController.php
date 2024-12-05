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
            $cartes = CarteCredit::withTrashed()->get();
            return view('cartes.index', compact('cartes'));
        } else {
            $cartes = CarteCredit::where('user_id', auth()->user()->id)->get();
            return view('cartes.index', compact('cartes'));
        }
    }

    /**
     * Show the form for creating a new credit card.
     */
    public function create()
    {
        return view('cartes.create');
    }

    /**
     * Store a newly created credit card in storage.
     */
    public function store(CarteCreditRequest $request)
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
    }

    /**
     * Display the specified credit card.
     */
    public function show(CarteCredit $carteCredit)
    {
        $this->authorize('view', $carteCredit);
        return view('cartes.show', compact('carteCredit'));
    }

    /**
     * Show the form for editing the specified credit card.
     */
    public function edit(CarteCredit $carteCredit)
    {
        $this->authorize('update', $carteCredit);
        return view('cartes.edit', compact('carteCredit'));
    }

    /**
     * Update the specified credit card in storage.
     */
    public function update(Request $request, CarteCredit $carteCredit)
    {
        $this->authorize('update', $carteCredit);

        $request->validate([
            'numero' => 'required|numeric|digits:16',
            'nom_titulaire' => 'required|string|max:255',
            'date_expiration' => 'required|date|after:today',
            'cvc' => 'required|numeric|digits:3',
        ]);

        // Nettoyage des données avant de mettre à jour la carte
        $carteCredit->numero = str_replace(['-', ' '], '', $request->numero);
        $carteCredit->nom_titulaire = e($request->nom_titulaire); // Échappe le nom du titulaire
        $carteCredit->date_expiration = \Carbon\Carbon::createFromFormat('Y-m', $request->date_expiration)->format('m/y');
        $carteCredit->cvc = $request->cvc;

        $carteCredit->save();

        return redirect()->route('carte-credit.index')->with('success', 'Carte de crédit mise à jour avec succès.');
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
