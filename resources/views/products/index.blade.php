@extends('layouts.app')

@section('title', 'Mes Produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📦 Mes Produits</h1>
    <a href="{{ route('products.create') }}"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        + Ajouter un produit
    </a>
</div>

@if($products->count() > 0)
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-600">Produit</th>
                    <th class="px-4 py-3 text-left text-gray-600">Catégorie</th>
                    <th class="px-4 py-3 text-left text-gray-600">Prix</th>
                    <th class="px-4 py-3 text-left text-gray-600">Stock</th>
                    <th class="px-4 py-3 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}"
                                        class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        📦
                                    </div>
                                @endif
                                <span class="font-medium">{{ $product->title }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $product->category->name }}</td>
                        <td class="px-4 py-3 font-semibold text-indigo-600">{{ number_format($product->price, 2) }} TND</td>
                        <td class="px-4 py-3 text-gray-500">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('products.show', $product) }}"
                                    class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                                    Voir
                                </a>
                                <a href="{{ route('products.edit', $product) }}"
                                    class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200 text-sm">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Supprimer ce produit ?')"
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 text-sm">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@else
    <div class="text-center py-12 bg-white rounded shadow">
        <p class="text-gray-500 text-xl">😕 Vous n'avez pas encore de produits.</p>
        <a href="{{ route('products.create') }}"
            class="text-indigo-600 hover:underline mt-2 inline-block">
            Ajouter votre premier produit
        </a>
    </div>
@endif
@endsection