@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Ajouter une Carte de Crédit</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('cartes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="numero" class="form-label">Numéro de Carte</label>
                    <input type="text" name="numero" id="numero" class="form-control" placeholder="1234456789101112" minlength="16" maxlength="16" required>
                </div>

                <div class="mb-3">
                    <label for="nom_titulaire" class="form-label">Nom du Titulaire</label>
                    <input type="text" name="nom_titulaire" id="nom_titulaire" class="form-control" maxlength="255" placeholder="Nom Prénom" required>
                </div>

                <div class="mb-3">
                    <label for="date_expiration" class="form-label">Date d'Expiration (mm/YY)</label>
                    <input
                        type="month"
                        name="date_expiration"
                        id="date_expiration"
                        class="form-control"
                        min="{{ now()->format('Y-m') }}"
                        required>
                </div>


                <div class="mb-3">
                    <label for="cvc" class="form-label">CVC</label>
                    <input type="text" name="cvc" id="cvc" class="form-control" minlength="3" maxlength="3" placeholder="123" required>
                </div>

                <button type="submit" class="btn btn-success">Ajouter la Carte</button>
            </form>
        </div>
    </div>
@endsection
