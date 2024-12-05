@extends('layouts.app')

@section('content')
    <!-- Affichage du titre en fonction du rôle de l'utilisateur -->
    @if (auth()->user()->isA('admin'))
        <h1 class="display-4 text-center mt-5 mb-5">Liste des cartes de crédit</h1>
    @else
        <h1 class="display-4 text-center mt-5 mb-5">Vos Cartes de Crédit</h1>
    @endif

    <!-- Bouton pour ajouter une carte si l'utilisateur est un utilisateur (user) -->
    @if (auth()->user()->isA('user'))
        <a href="{{ route('carte-credit.create') }}" class="btn btn-primary mb-3">Ajouter une Carte</a>
    @endif

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table des cartes de crédit -->
    @if ($cartes && $cartes->count() > 0)
        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Nom du Titulaire</th>
                    <th>Date d'Expiration</th>
                    @if (auth()->user()->isA('user'))
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($cartes as $carte)
                    <tr>
                        <td>{{ str_repeat('*', 12) . substr($carte->numero, -4) }}</td>
                        <td>{{ $carte->nom_titulaire }}</td>
                        <td>{{ $carte->date_expiration }}</td>
                        @if (auth()->user()->isA('user'))
                            <td>
                                @if (!$carte->deleted_at)
                                    <form action="{{ route('carte-credit.destroy', $carte) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">Supprimée</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning mt-3">
            Aucune carte de crédit trouvée.
        </div>
    @endif
@endsection
