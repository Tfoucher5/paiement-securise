<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Paiement;
use App\Models\CarteCredit;
use App\Models\Remboursement;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Remboursement extends Model
{
    use HasFactory;

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    public function carte()
    {
        return $this->belongsTo(CarteCredit::class, 'carte_id');
    }
}

