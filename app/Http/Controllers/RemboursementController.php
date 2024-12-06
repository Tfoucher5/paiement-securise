<?php

namespace App\Http\Controllers;

use App\Models\Remboursement;
use App\Models\Paiement;
use Illuminate\Http\Request;

class RemboursementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->isA('admin')) {
            $remboursements = Remboursement::with('carte.user')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $remboursements = Remboursement::with('carte.user')
                ->whereHas('paiement', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('remboursement.index', compact('remboursements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Remboursement $remboursement, $numCommande)
    {
        $paiements = Paiement::where('num_commande', $numCommande)->get();
        return view('remboursement.create', compact('paiements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pourcentage' => 'required|integer|min:0|max:100',
            'montant_rembourse' => 'required|numeric|min:0.01',
        ]);

        $data = $request->all();
        $paiement = Paiement::with('carte')->find($data['paiement_id']);

        $remboursement = new Remboursement();
        $remboursement->paiement_id = $paiement->id;
        $remboursement->carte_id = $paiement->carte_id;
        $remboursement->montant = $data['montant_rembourse'];

        $remboursement->save();

        return redirect()->route('remboursement.index')->with('success', 'Remboursement effectué avec succès.');
    }
}
