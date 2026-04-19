@extends('layouts.app')

@section('title', 'Ma Wishlist')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">❤️ Ma Wishlist</h1>

@if($wishlists->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($wishlists as $wishlist)
            <div class="bg-white rounded shadow hover:shadow-lg transition">
                @if($wishlist->product->image)
                    <img src="{{ Storage::url($wishlist->product->image) }}"
                        alt="{{ $wishlist->product->title }}"
                        class="w-full h-48 object-cover rounded-t">
                @else
                    <div class="w-full h-48 bg-gray-200 rounded-t flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">📦</span>
                    </div>
                @endif

                <div class="p-4">
                    <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded">
                        {{ $wishlist->product->category->name }}
                    </span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">
                        {{ $wishlist->product->title }}
                    </h3>
                    <p class="text-xl font-bold text-indigo-600 mt-2">
                        {{ number_format($wishlist->product->price, 2) }} TND
                    </p>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('products.show', $wishlist->product) }}"
                            class="bg-gray-100 text-gray-700 px-3 py-2 rounded hover:bg-gray-200 text-sm flex-1 text-center">
                            Voir le produit
                        </a>
                        <form method="POST" action="{{ route('cart.add', $wishlist->product) }}">
                            @csrf
                            <button type="submit"
                                class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-700 text-sm">
                                🛒
                            </button>
                        </form>
                        <form method="POST" action="{{ route('wishlist.destroy', $wishlist->product) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-100 text-red-600 px-3 py-2 rounded hover:bg-red-200 text-sm">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $wishlists->links() }}</div>
@else
    <div class="text-center py-12 bg-white rounded shadow">
        <p class="text-gray-500 text-xl">❤️ Votre wishlist est vide.</p>
        <a href="{{ route('home') }}"
            class="text-indigo-600 hover:underline mt-2 inline-block">
            Découvrir nos produits
        </a>
    </div>
@endif
@endsection