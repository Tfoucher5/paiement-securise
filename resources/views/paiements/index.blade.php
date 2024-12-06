@extends('layouts.app')

@section('content')
    <div class="bg-light p-3">
        <div class="container bg-white rounded border p-3 mt-5">
            <div class="d-flex justify-content-between my-4">
                <strong class="h3">Liste des paiements</strong>
                @if (auth()->user()->isA('user'))
                    <a class="btn btn-success" href="{{ route('paiement.create') }}">Ajouter un paiement</a>
                @endif
            </div>

            @if ($paiements->isEmpty())
                <div class="alert alert-info text-center">{{ __('Aucun paiement trouvé') }}</div>
            @else
                <div class="row">
                    @foreach ($paiements as $paiement)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">{{ $paiement->user->name }}</h5>
                                        <hr>
                                        <p class="card-text">
                                            <strong>Montant :</strong> {{ $paiement->montant }} €<br>
                                            <strong>Carte :</strong>
                                            @if (auth()->user()->isA('admin'))
                                                {{ str_repeat('*', 12) . substr($paiement->carte->numero, -4) }}
                                            @else
                                                {{ substr($paiement->carte->numero, 0, 4) . str_repeat('*', 8) . substr($paiement->carte->numero, -4) }}
                                            @endif
                                            <br>
                                            <strong>Expiration :</strong> {{ $paiement->carte->date_expiration }}
                                        </p>
                                        <p class="text-muted"><strong>Date :</strong> {{ \Carbon\Carbon::parse($paiement->created_at)->translatedFormat('j F Y') }}</p>

                                        @if (auth()->user()->isA('admin'))
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-primary btn-sm" href="{{ route('remboursement.create', $paiement) }}">{{ __("Remboursement") }}</a>
                                                </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
