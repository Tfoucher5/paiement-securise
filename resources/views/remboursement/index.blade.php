@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center" style="min-height: 100vh; flex-direction: column;">
        <!-- Titre centré -->
        <h3 class="display-4 mb-5 mt-5 text-center">Remboursements</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card" style="width: 100%; max-width: 900px;">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead style="background-color: #007bff; color: white;">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Numéro de Carte</th>
                            <th scope="col" class="text-center">Montant Total</th>
                            <th scope="col" class="text-center">Montant Remboursé</th>
                            <th scope="col" class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($remboursements as $remboursement)
                            <tr>
                                <td class="text-center">{{ $remboursement->id }}</td>
                                <td class="text-center">{{ $remboursement->carte->numero }}</td>
                                <td class="text-center">{{ $remboursement->paiement->montant }} €</td>
                                <td class="text-center">{{ $remboursement->montant }} €</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($remboursement->created_at)->translatedFormat('j F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center alert alert-warning">Aucun remboursement enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
