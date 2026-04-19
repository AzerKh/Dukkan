@extends('layouts.app')

@section('title', 'Mon Panier')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">🛒 Mon Panier</h1>

@if(count($cart) > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Liste des articles -->
        <div class="md:col-span-2">
            @foreach($cart as $id => $item)
                <div class="bg-white rounded shadow p-4 mb-4 flex items-center gap-4">
                    <!-- Image -->
                    @if($item['image'])
                        <img src="{{ Storage::url($item['image']) }}"
                            class="w-20 h-20 object-cover rounded">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center text-2xl">
                            📦
                        </div>
                    @endif

                    <!-- Détails -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">{{ $item['title'] }}</h3>
                        <p class="text-indigo-600 font-bold">{{ number_format($item['price'], 2) }} TND</p>
                    </div>

                    <!-- Quantité -->
                    <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                            min="1" max="99"
                            class="border rounded px-2 py-1 w-16 text-center focus:outline-none focus:border-indigo-500">
                        <button type="submit"
                            class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                            Mettre à jour
                        </button>
                    </form>

                    <!-- Supprimer -->
                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-200 text-sm">
                            🗑️
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Résumé -->
        <div class="bg-white rounded shadow p-6 h-fit">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé</h2>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Sous-total</span>
                <span class="font-semibold">{{ number_format($total, 2) }} TND</span>
            </div>
            <hr class="my-4">
            <div class="flex justify-between mb-4">
                <span class="text-gray-800 font-bold">Total</span>
                <span class="text-indigo-600 font-bold text-xl">{{ number_format($total, 2) }} TND</span>
            </div>
            <a href="{{ route('orders.create') }}"
                class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 w-full block text-center">
                ✅ Passer la commande
            </a>
            <a href="{{ route('home') }}"
                class="bg-gray-100 text-gray-700 px-6 py-3 rounded hover:bg-gray-200 w-full block text-center mt-3">
                Continuer les achats
            </a>
        </div>
    </div>
@else
    <div class="text-center py-12 bg-white rounded shadow">
        <p class="text-gray-500 text-xl">🛒 Votre panier est vide.</p>
        <a href="{{ route('home') }}"
            class="text-indigo-600 hover:underline mt-2 inline-block">
            Découvrir nos produits
        </a>
    </div>
@endif
@endsection