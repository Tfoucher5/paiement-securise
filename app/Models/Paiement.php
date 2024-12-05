<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CarteCredit;

class Paiement extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carte()
    {
        return $this->belongsTo(CarteCredit::class);
    }

    public function remboursement()
    {
        return $this->hasMany(Remboursement::class);
    }
}
