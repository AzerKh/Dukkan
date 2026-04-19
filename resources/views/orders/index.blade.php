@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">📦 Mes Commandes</h1>

@if($orders->count() > 0)
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-gray-600">Date</th>
                    <th class="px-4 py-3 text-left text-gray-600">Total</th>
                    <th class="px-4 py-3 text-left text-gray-600">Statut</th>
                    <th class="px-4 py-3 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-3 font-semibold text-indigo-600">
                            {{ number_format($order->total_price, 2) }} TND
                        </td>
                        <td class="px-4 py-3">
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
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('orders.show', $order) }}"
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                                    Détails
                                </a>
                                @if($order->status == 'en_attente')
                                    <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            onclick="return confirm('Annuler cette commande ?')"
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 text-sm">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@else
    <div class="text-center py-12 bg-white rounded shadow">
        <p class="text-gray-500 text-xl">📦 Vous n'avez pas encore de commandes.</p>
        <a href="{{ route('home') }}"
            class="text-indigo-600 hover:underline mt-2 inline-block">
            Découvrir nos produits
        </a>
    </div>
@endif
@endsection