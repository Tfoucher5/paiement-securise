@extends('layouts.app')

@section('content')
    <form action="{{ route('paiement.enregistrer') }}" method="POST">
        @csrf
        <input type="number" name="montant" placeholder="Montant" required>
        <input type="text" name="carte_4_premiers" placeholder="4 premiers numéros" required>
        <input type="text" name="carte_4_derniers" placeholder="4 derniers numéros" required>
        <input type="date" name="date_expiration" required>
        <input type="text" name="num_transaction" placeholder="Numéro de transaction" required>
        <button type="submit">Enregistrer le paiement</button>
    </form>
@endsection

