<?php

namespace App\Policies;

use App\Models\Paiement;
use App\Models\User;

class PaiementPolicy
{
    public function rembourser(User $utilisateur, Paiement $paiement)
    {
        return $utilisateur->can('rembourser');
    }
}

