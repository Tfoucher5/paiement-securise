@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; flex-direction: column;">
        <!-- Titre centré au-dessus de la carte -->
        <h3 class="display-4 mb-4 text-center">Rembourser un Paiement</h3>

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
                <form action="{{ route('remboursement.store') }}" method="POST">
                    @csrf

                    @foreach ($paiement as $paiementItem)
                    <input type="hidden" name="paiement_id" value="{{ $paiementItem->id }}">
                        <div class="mb-3">
                            <label class="form-label">
                                Carte : {{ str_repeat('*', 12) . substr($paiementItem->carte->numero, -4) }}
                            </label><br>
                            <label class="form-label">
                                Titulaire : {{ $paiementItem->carte->user->name }}
                            </label><br>
                            <label class="form-label">
                                Montant Total : <span id="montant_total_display">{{ $paiementItem->montant }}</span> €
                            </label>
                            <input type="hidden" id="montant_total" value="{{ $paiementItem->montant }}">
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label for="pourcentage_slider" class="form-label">
                            Pourcentage choisi : <span id="pourcentage_display">0%</span>
                        </label>
                        <input type="range" id="pourcentage_slider" name="pourcentage" min="0" max="100" step="1" value="0"
                            oninput="updateValues()">
                    </div>

                    <div class="mb-3">
                        <label for="montant_rembourse" class="form-label">
                            Montant à rembourser : <span id="montant_rembourse_display">0.00</span>
                        </label>
                        <input type="hidden" id="montant_rembourse" name="montant_rembourse" value="0">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Rembourser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateValues() {
            const montantTotal = parseFloat(document.getElementById('montant_total').value);

            const pourcentage = parseInt(document.getElementById('pourcentage_slider').value);

            const montantRembourse = (montantTotal * pourcentage) / 100;

            document.getElementById('pourcentage_display').innerText = pourcentage + '%';
            document.getElementById('montant_rembourse_display').innerText = montantRembourse.toFixed(2) + ' €';
            document.getElementById('montant_rembourse').value = montantRembourse.toFixed(2);
        }
    </script>
@endsection
