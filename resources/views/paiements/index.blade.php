@extends('layouts.app')

@section('content')
    <div class="bg-gray-200 p-px">
        <div class="w-4/6 bg-white mx-auto rounded-xl border-2 border-gray-400 p-2 mt-5 ">
            <div class="flex justify-around my-8">
                <strong class="text-4xl">liste des paiements</strong>
            </div>
                <a class="mx-auto p-2 px-5 rounded bg-green-500" href="{{ route('paiement.create') }}">{{ __("Create") }}</a>
            <ul class="list-group">

            @forelse ($paiements as $paiement)
                <li class="list-group-item">
                    <div class="flex justify-between align-items-center my-5 border rounded">
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->user->name }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->montant }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->carte->numero }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ \Carbon\Carbon::parse($paiement->created_at)->translatedFormat('j F Y') }}</div>

                        @if (auth()->user()->isA('admin'))
                            <div class="flex gap-2">
                                <a class="flex justify-center gap-2 p-2 px-5 rounded bg-blue-300" href="{{ route('remboursement.index', $paiement) }}">{{ __("Remboursement") }}</a>
                            </div>
                        @endif

                    </div>
                </li>
                @empty
                    {{ __('Unknown paiement ') }}
                @endforelse
            </ul>
        </div>
    </div>
@endsection
