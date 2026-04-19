@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">⚙️ Dashboard Admin</h1>
    <div class="flex gap-3">
        <a href="{{ route('admin.users') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">👥 Utilisateurs</a>
        <a href="{{ route('admin.products') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">📦 Produits</a>
        <a href="{{ route('admin.orders') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">🛒 Commandes</a>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded shadow p-4 text-center">
        <p class="text-3xl font-bold text-indigo-600">{{ $stats['users'] }}</p>
        <p class="text-gray-500 mt-1">👥 Utilisateurs</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['products'] }}</p>
        <p class="text-gray-500 mt-1">📦 Produits</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['orders'] }}</p>
        <p class="text-gray-500 mt-1">🛒 Commandes</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
        <p class="text-3xl font-bold text-red-600">{{ $stats['pending'] }}</p>
        <p class="text-gray-500 mt-1">⏳ En attente</p>
    </div>
    <div class="bg-white rounded shadow p-4 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['revenue'], 2) }}</p>
        <p class="text-gray-500 mt-1">💰 Revenus TND</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Dernières commandes -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-bold mb-4">🛒 Dernières commandes</h2>
        @foreach($recentOrders as $order)
            <div class="flex justify-between items-center py-2 border-b">
                <div>
                    <p class="font-medium">#{{ $order->id }} — {{ $order->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-indigo-600">{{ number_format($order->total_price, 2) }} TND</span>
                    @if($order->status == 'en_attente')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">⏳</span>
                    @elseif($order->status == 'validee')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">✅</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">❌</span>
                    @endif
                </div>
            </div>
        @endforeach
        <a href="{{ route('admin.orders') }}" class="text-indigo-600 hover:underline mt-3 inline-block text-sm">
            Voir toutes les commandes →
        </a>
    </div>

    <!-- Derniers utilisateurs -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-bold mb-4">👥 Derniers utilisateurs</h2>
        @foreach($recentUsers as $user)
            <div class="flex justify-between items-center py-2 border-b">
                <div>
                    <p class="font-medium">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
                <span class="px-2 py-1 rounded text-xs
                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ $user->role }}
                </span>
            </div>
        @endforeach
        <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:underline mt-3 inline-block text-sm">
            Voir tous les utilisateurs →
        </a>
    </div>
</div>
@endsection