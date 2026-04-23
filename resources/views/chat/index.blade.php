@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 gradient-text">💬 Mes Conversations</h2>

    @if($contacts->isEmpty())
        <div class="bg-white rounded-2xl p-10 text-center shadow-sm">
            <div class="text-5xl mb-4">💬</div>
            <p class="text-gray-500">Aucune conversation pour le moment.</p>
            <p class="text-sm text-gray-400 mt-2">Visitez un produit et contactez le vendeur !</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 btn-primary text-white px-6 py-2 rounded-xl font-semibold">
                Voir les produits
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($contacts as $contact)
                <a href="{{ route('chat.show', $contact->id) }}"
                   class="flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm card-hover">
                    <div class="w-12 h-12 rounded-full gradient-bg flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800">{{ $contact->name }}</div>
                        <div class="text-sm text-gray-400">{{ $contact->email }}</div>
                    </div>
                    <span class="text-purple-500 font-bold">→</span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection