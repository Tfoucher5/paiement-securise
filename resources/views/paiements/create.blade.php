@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <strong>Créer un paiement</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('paiement.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="carte_id">Carte de Crédit</label>
                        <select name="carte_id" id="carte_id" class="form-control @error('carte_id') is-invalid @enderror">
                            <option value="" disabled {{ old('carte_id') ? '' : 'selected' }}>Sélectionner une carte</option>
                            @forelse ($cartes as $carte)
                                <option value="{{ $carte->id }}"
                                    {{ old('carte_id', $cartes->first()->id ?? '') == $carte->id ? 'selected' : '' }}>
                                    {{ str_repeat('*', 12) . substr($carte->numero, -4) }} | {{ $carte->nom_titulaire }}
                                </option>
                            @empty
                                <option disabled>Aucune carte disponible</option>
                            @endforelse
                        </select>
                        @error('carte_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <input type="text" name="montant" id="montant" value="{{ old('montant') }}" class="form-control @error('montant') is-invalid @enderror" placeholder="Entrez le montant">
                        @error('montant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Créer le paiement</button>
                </form>
            </div>
        </div>
    </div>
@endsection
