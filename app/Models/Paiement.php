<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'montant', 'carte_4_premiers', 'carte_4_derniers', 'date_expiration', 'num_transaction'
    ];

    // Relier à l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
