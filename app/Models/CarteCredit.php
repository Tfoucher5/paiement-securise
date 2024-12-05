<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Paiement;


class CarteCredit extends Model
{
    use HasFactory, softDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'numero',
        'nom_titulaire',
        'date_expiration',
        'cvc',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paiement()
    {
        return $this->hasMany(Paiement::class);
    }
}
