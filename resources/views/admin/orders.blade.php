@extends('layouts.app')

@section('title', 'Gestion Commandes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🛒 Gestion des Commandes</h1>
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
        ← Dashboard
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-gray-600">Client</th>
                <th class="px-4 py-3 text-left text-gray-600">Total</th>
                <th class="px-4 py-3 text-left text-gray-600">Statut</th>
                <th class="px-4 py-3 text-left text-gray-600">Date</th>
                <th class="px-4 py-3 text-left text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                    <td class="px-4 py-3">{{ $order->user->name }}</td>
                    <td class="px-4 py-3 font-semibold text-indigo-600">
                        {{ number_format($order->total_price, 2) }} TND
                    </td>
                    <td class="px-4 py-3">
                        @if($order->status == 'en_attente')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">⏳ En attente</span>
                        @elseif($order->status == 'validee')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">✅ Validée</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">❌ Annulée</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <div class="flex gap-2">
                                <select name="status"
                                    class="border rounded px-2 py-1 text-sm focus:outline-none focus:border-indigo-500">
                                    <option value="en_attente" {{ $order->status == 'en_attente' ? 'selected' : '' }}>
                                        ⏳ En attente
                                    </option>
                                    <option value="validee" {{ $order->status == 'validee' ? 'selected' : '' }}>
                                        ✅ Validée
                                    </option>
                                    <option value="annulee" {{ $order->status == 'annulee' ? 'selected' : '' }}>
                                        ❌ Annulée
                                    </option>
                                </select>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection