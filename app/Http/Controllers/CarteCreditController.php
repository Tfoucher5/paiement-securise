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
        // Si la validation passe, les données sont déjà validées et prêtes à être utilisées
        $validatedData = $request->validated(); // Récupère les données validées

        // Nettoyage du numéro de carte
        $numero = str_replace(['-', ' '], '', $validatedData['numero']);

        // Formate la date d'expiration pour le stockage
        $dateExpiration = \Carbon\Carbon::createFromFormat('Y-m', $validatedData['date_expiration'])->format('m/y');

        // Création de la carte de crédit
        $carte = new CarteCredit;
        $carte->user_id = auth()->user()->id; // Associe l'utilisateur connecté
        $carte->numero = $numero; // Stocke le numéro sans les tirets ni espaces
        $carte->nom_titulaire = $validatedData['nom_titulaire']; // Stocke le nom du titulaire
        $carte->date_expiration = $dateExpiration; // Stocke la date d'expiration formatée
        $carte->cvc = $validatedData['cvc']; // Stocke le code CVC
        $carte->save(); // Sauvegarde la carte

        // Redirige vers la liste des cartes avec un message de succès
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

        $carteCredit->update($request->all());

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
