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
                        <div class="flex">
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->motif->titre }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->date_debut }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ $paiement->user->name }}</div>
                            <div class='min-w-48 my-auto text-center'>{{ __($paiement->status) }}</div>
                        </div>
                        <div class="flex gap-2">
                            @if ($paiement->deleted_at === null)
                                @can('paiement-show')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-blue-300" href="{{ route('paiement.show', $paiement) }}">{{ __("Details") }}</a>
                                @endcan
                                @can('paiement-edit')
                                    <a class="flex justify-center gap-2 p-2 px-5 rounded bg-orange-300" href="{{ route('paiement.edit', $paiement) }}">{{ __("Edit") }}</a>
                                @endcan
                                @can('paiement-delete')
                                    <form action="{{ route('paiement.destroy', $paiement) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-red-300">{{ __("Delete") }}</button>
                                    </form>
                                @endcan
                            @else
                                @can('paiement-restore')
                                    {{-- <form action="{{ route('paiement.restore', $paiement) }}" method="post"> --}}
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="flex justify-center gap-2 p-2 px-5 rounded bg-purple-300">{{ __("Restore") }}</button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                    {{ __('Unknown paiement ') }}
                @endforelse
            </ul>
        </div>
    </div>
@endsection
