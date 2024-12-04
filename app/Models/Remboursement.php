<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Remboursement;
use Illuminate\Http\Request;

class RemboursementController extends Controller
{
    public function rembourser(Request $request, Paiement $paiement)
    {
        $this->authorize('rembourser', $paiement);

        $request->validate([
            'montant' => 'required|numeric|min:0.01|max:' . $paiement->montant,
        ]);

        $remboursement = Remboursement::create([
            'paiement_id' => $paiement->id,
            'montant' => $request->montant,
        ]);

        return response()->json($remboursement, 201);
    }
}

