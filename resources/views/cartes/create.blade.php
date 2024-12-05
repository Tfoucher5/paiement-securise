@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; flex-direction: column;">
        <!-- Titre centré au-dessus de la carte -->
        <h3 class="display-4 mb-4 text-center">Ajouter une Carte de Crédit</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <form action="{{ route('carte-credit.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="numero" class="form-label">Numéro de Carte</label>
                        <input
                            type="text"
                            name="numero"
                            id="numero"
                            class="form-control"
                            placeholder="1234 5678 9101 1121"
                            minlength="16"
                            maxlength="19"
                            value="{{ old('numero') }}"
                            required
                            oninput="formatCardNumber(this)">
                        <div class="form-text">Entrez le numéro de votre carte sans espaces ni tirets.</div>
                    </div>

                    <div class="mb-3">
                        <label for="nom_titulaire" class="form-label">Nom du Titulaire</label>
                        <input
                            type="text"
                            name="nom_titulaire"
                            id="nom_titulaire"
                            class="form-control"
                            maxlength="255"
                            placeholder="Nom Prénom"
                            value="{{ old('nom_titulaire') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="date_expiration" class="form-label">Date d'Expiration (mm/YY)</label>
                        <input
                            type="month"
                            name="date_expiration"
                            id="date_expiration"
                            class="form-control"
                            min="{{ now()->format('Y-m') }}"
                            value="{{ old('date_expiration') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="cvc" class="form-label">CVC</label>
                        <input
                            type="text"
                            name="cvc"
                            id="cvc"
                            class="form-control"
                            minlength="3"
                            maxlength="3"
                            placeholder="123"
                            value="{{ old('cvc') }}"
                            required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Ajouter la Carte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour formater le numéro de la carte avec des tirets
        function formatCardNumber(input) {
            // Enlever tout caractère non numérique
            let value = input.value.replace(/\D/g, '');

            // Ajouter des tirets tous les 4 chiffres
            let formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1-');

            // Mettre à jour la valeur de l'input sans affecter la longueur maximale
            input.value = formattedValue;

            // Ne pas dépasser le maxlength de 19 caractères
            if (input.value.length > 19) {
                input.value = input.value.slice(0, 19);
            }
        }
    </script>
@endsection
