@extends('layouts.app')

@section('title', $product->title)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Image produit -->
    <div>
        @if($product->image)
            <img src="{{ $product->image_url }}"
                alt="{{ $product->title }}"
                class="w-full rounded shadow">
        @else
            <div class="w-full h-80 bg-gray-200 rounded flex items-center justify-center">
                <span class="text-gray-400 text-6xl">📦</span>
            </div>
        @endif
    </div>

    <!-- Détails produit -->
    <div class="bg-white p-6 rounded shadow">
        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded">
            {{ $product->category->name }}
        </span>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">{{ $product->title }}</h1>
        <p class="text-gray-500 mt-4">{{ $product->description }}</p>

        <div class="mt-4">
            <span class="text-3xl font-bold text-indigo-600">
                {{ number_format($product->price, 2) }} TND
            </span>
        </div>

        <div class="mt-2">
            <span class="text-sm text-gray-500">
                Stock : {{ $product->stock }} disponible(s)
            </span>
        </div>

        <!-- Note moyenne -->
        @if($avgRating)
            <div class="mt-2">
                <span class="text-yellow-500">★</span>
                <span class="text-gray-700">{{ number_format($avgRating, 1) }} / 5</span>
                <span class="text-gray-400 text-sm">({{ $reviews->count() }} avis)</span>
            </div>
        @endif

        <div class="mt-6 flex gap-3">
            @auth
                <form method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
                        🛒 Ajouter au panier
                    </button>
                </form>
                <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                    @csrf
                    <button type="submit"
                        class="bg-pink-100 text-pink-600 px-6 py-3 rounded hover:bg-pink-200">
                        ❤️ Wishlist
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700">
                    Connectez-vous pour acheter
                </a>
            @endauth
        </div>

        <div class="mt-4">
            <p class="text-sm text-gray-500">
                Vendu par : <span class="font-semibold">{{ $product->user->name }}</span>
            </p>
        </div>
    </div>
</div>

<!-- Section Avis -->
<div class="mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">⭐ Avis clients</h2>

    @auth
        <!-- Formulaire avis -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Laisser un avis</h3>
            <form method="POST" action="{{ route('reviews.store', $product) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Note</label>
                    <select name="rating" class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500">
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Bien</option>
                        <option value="3">⭐⭐⭐ Moyen</option>
                        <option value="2">⭐⭐ Mauvais</option>
                        <option value="1">⭐ Très mauvais</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Commentaire</label>
                    <textarea name="comment" rows="3"
                        class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500"
                        placeholder="Votre avis..."></textarea>
                </div>
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Envoyer l'avis
                </button>
            </form>
        </div>
    @endauth

    <!-- Liste des avis -->
    @forelse($reviews as $review)
        <div class="bg-white p-4 rounded shadow mb-3">
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-semibold">{{ $review->user->name }}</span>
                    <span class="text-yellow-500 ml-2">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </span>
                </div>
                <span class="text-gray-400 text-sm">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            @if($review->comment)
                <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
            @endif
            @auth
                @if($review->user_id === Auth::id())
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 text-sm hover:underline">
                            Supprimer
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    @empty
        <p class="text-gray-500">Aucun avis pour ce produit.</p>
    @endforelse
</div>
@endsection