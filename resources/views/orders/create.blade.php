@extends('layouts.app')

@section('title', 'Passer la commande')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">✅ Passer la commande</h1>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-4">Récapitulatif</h2>
        @foreach($cart as $item)
            <div class="flex justify-between py-2 border-b">
                <span>{{ $item['title'] }} x{{ $item['quantity'] }}</span>
                <span class="font-semibold">{{ number_format($item['price'] * $item['quantity'], 2) }} TND</span>
            </div>
        @endforeach
        <div class="flex justify-between mt-4">
            <span class="text-xl font-bold">Total</span>
            <span class="text-xl font-bold text-indigo-600">{{ number_format($total, 2) }} TND</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Informations de livraison</h2>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Adresse *</label>
                <textarea name="address" rows="3"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('address') border-red-500 @enderror"
                    placeholder="Votre adresse complète...">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Téléphone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('phone') border-red-500 @enderror"
                    placeholder="Votre numéro de téléphone...">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
                    ✅ Confirmer la commande
                </button>
                <a href="{{ route('cart.index') }}"
                    class="bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400">
                    Retour au panier
                </a>
            </div>
        </form>
    </div>
</div>
@endsection