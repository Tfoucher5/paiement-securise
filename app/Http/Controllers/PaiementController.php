<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\CarteCredit;
use App\Models\Remboursement;
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
            $paiements = Paiement::orderBy('created_at', 'desc')->get();
        } else {
            $paiements = Paiement::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('paiements.index', compact('paiements'));
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
            $montant = e($request->input('montant'));

            $paiement = new Paiement;
            $paiement->carte_id = $request['carte_id'];
            $paiement->user_id = auth()->user()->id;
            $paiement->montant = $montant;
            $paiement->num_commande = $this->generateRandomCode(10);
            $paiement->save();

            return redirect()->route('paiement.index')->with('success', 'Paiement ajouté avec succès');
        }
    }

    /**
     * Génère un code aléatoire composé de chiffres et de lettres.
     *
     * @param int $length La longueur du code à générer.
     * @return string
     */
    private function generateRandomCode(int $length): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Chiffres et lettres majuscules
        $charactersLength = strlen($characters);
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomCode;
    }

}
