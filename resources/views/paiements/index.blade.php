@extends('layouts.app')

@section('content')
    <h1>Mes Paiements</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Montant</th>
                <th>Carte</th>
                <th>Date d'expiration</th>
                <th>Transaction</th>
                @if (auth()->user()->hasRole('admin'))
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
                <tr>
                    <td>{{ number_format($paiement->montant, 2, ',', ' ') }} €</td>
                    <td>{{ $paiement->carte_4_premiers }}****{{ $paiement->carte_4_derniers }}</td>
                    <td>{{ $paiement->date_expiration }}</td>
                    <td>{{ $paiement->num_transaction }}</td>
                    @if (auth()->user()->isA('admin'))
                        <td>
                            <form action="{{ route('paiement.rembourser', $paiement->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Rembourser</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

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
