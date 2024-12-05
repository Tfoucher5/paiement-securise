<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'numero', 'date_expiration', 'type',
    ];

    protected $hidden = [
        'numero', // Masquer le numéro complet de la carte
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($carteCredit) {
            $carteCredit->numero = encrypt($carteCredit->numero); // Chiffrement du numéro de carte
        });

        static::retrieved(function ($carteCredit) {
            $carteCredit->numero = decrypt($carteCredit->numero); // Déchiffrement lors de la récupération
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
