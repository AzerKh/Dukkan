@extends('layouts.app')

@section('title', 'Commande #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📦 Commande #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}"
            class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
            ← Retour
        </a>
    </div>

    <!-- Infos commande -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">Date</p>
                <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Statut</p>
                @if($order->status == 'en_attente')
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">
                        ⏳ En attente
                    </span>
                @elseif($order->status == 'validee')
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">
                        ✅ Validée
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">
                        ❌ Annulée
                    </span>
                @endif
            </div>
            <div>
                <p class="text-gray-500 text-sm">Adresse</p>
                <p class="font-semibold">{{ $order->address }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Téléphone</p>
                <p class="font-semibold">{{ $order->phone }}</p>
            </div>
        </div>
    </div>

    <!-- Articles commandés -->
    <div class="bg-white rounded shadow overflow-hidden mb-6">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-600">Produit</th>
                    <th class="px-4 py-3 text-left text-gray-600">Prix unitaire</th>
                    <th class="px-4 py-3 text-left text-gray-600">Quantité</th>
                    <th class="px-4 py-3 text-left text-gray-600">Sous-total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($item->product->image)
                                    <img src="{{ Storage::url($item->product->image) }}"
                                        class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        📦
                                    </div>
                                @endif
                                <span>{{ $item->product->title }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ number_format($item->price, 2) }} TND</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 font-semibold">
                            {{ number_format($item->price * $item->quantity, 2) }} TND
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold">Total</td>
                    <td class="px-4 py-3 font-bold text-indigo-600 text-lg">
                        {{ number_format($order->total_price, 2) }} TND
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($order->status == 'en_attente')
        <form method="POST" action="{{ route('orders.cancel', $order) }}">
            @csrf
            @method('PATCH')
            <button type="submit"
                onclick="return confirm('Annuler cette commande ?')"
                class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">
                ❌ Annuler la commande
            </button>
        </form>
    @endif
</div>
@endsection