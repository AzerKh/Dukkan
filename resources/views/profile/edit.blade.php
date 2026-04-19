@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">⚙️ Gérer mon compte</h1>

    <!-- Informations du profil -->
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">📝 Informations personnelles</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nom</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                💾 Sauvegarder
            </button>

            @if(session('status') === 'profile-updated')
                <span class="text-green-600 ml-3">✅ Profil mis à jour !</span>
            @endif
        </form>
    </div>

    <!-- Statistiques utilisateur -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-2xl font-bold text-indigo-600">{{ $user->products->count() }}</p>
            <p class="text-gray-500 text-sm mt-1">📦 Produits</p>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $user->orders->count() }}</p>
            <p class="text-gray-500 text-sm mt-1">🛒 Commandes</p>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-2xl font-bold text-pink-600">{{ $user->wishlists->count() }}</p>
            <p class="text-gray-500 text-sm mt-1">❤️ Wishlist</p>
        </div>
    </div>

    <!-- Supprimer le compte -->
    <div class="bg-white rounded shadow p-6 border border-red-200">
        <h2 class="text-xl font-bold text-red-600 mb-4">⚠️ Zone dangereuse</h2>
        <p class="text-gray-500 mb-4">La suppression de votre compte est irréversible.</p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Confirmez avec votre mot de passe
                </label>
                <input type="password" name="password"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-red-500">
                @error('password', 'userDeletion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')"
                class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                🗑️ Supprimer mon compte
            </button>
        </form>
    </div>
</div>
@endsection