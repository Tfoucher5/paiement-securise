@extends('layouts.app')

@section('content')
    <div class="bg-gray-200 p-px">
        <div class="w-4/6 bg-white mx-auto rounded-xl border-2 border-gray-400 p-2 mt-5 ">

            @forelse ($remboursements as $remboursement)
                <li class="list-group-item">
                    <div class="flex justify-between align-items-center my-5 border rounded">
                            <div class='min-w-48 my-auto text-center'>{{ $remboursement->id}}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $remboursement->carte->numero}}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $remboursement->paiement->montant }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $remboursement->montant }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ \Carbon\Carbon::parse($remboursement->created_at)->translatedFormat('j F Y') }}</div>
                    </div>
                </li>
                @empty
                    {{ __('Unknown remboursement ') }}
                @endforelse
            </ul>
        </div>
    </div>
@endsection
