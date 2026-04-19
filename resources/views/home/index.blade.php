@extends('layouts.app')

@section('title', 'Catalogue')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">🛍️ Catalogue</h1>

    <!-- Formulaire de recherche et filtres -->
    <form method="GET" action="{{ route('home') }}" class="bg-white p-4 rounded shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Recherche -->
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Rechercher un produit..."
                class="border rounded px-3 py-2 col-span-2 focus:outline-none focus:border-indigo-500">

            <!-- Catégorie -->
            <select name="category" class="border rounded px-3 py-2 focus:outline-none focus:border-indigo-500">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <!-- Tri -->
            <select name="sort" class="border rounded px-3 py-2 focus:outline-none focus:border-indigo-500">
                <option value="">Trier par...</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
            </select>
        </div>
        <div class="mt-3 flex gap-2">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                🔍 Rechercher
            </button>
            <a href="{{ route('home') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Réinitialiser
            </a>
        </div>
    </form>

    <!-- Grille de produits -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded shadow hover:shadow-lg transition">
                    <!-- Image -->
                    @if($product->image)
    <img src="{{ $product->image_url }}"
                            alt="{{ $product->title }}"
                            class="w-full h-48 object-cover rounded-t">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-t flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">📦</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <!-- Catégorie -->
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded">
                            {{ $product->category->name }}
                        </span>

                        <!-- Titre -->
                        <h3 class="text-lg font-semibold text-gray-800 mt-2">
                            {{ $product->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-500 text-sm mt-1">
                            {{ Str::limit($product->description, 80) }}
                        </p>

                        <!-- Prix et actions -->
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-xl font-bold text-indigo-600">
                                {{ number_format($product->price, 2) }} TND
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                                    Détails
                                </a>
                                @auth
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm">
                                            🛒 Ajouter
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-xl">😕 Aucun produit trouvé.</p>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                Voir tous les produits
            </a>
        </div>
    @endif
</div>
@endsection