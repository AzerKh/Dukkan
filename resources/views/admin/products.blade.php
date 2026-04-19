@extends('layouts.app')

@section('title', 'Gestion Produits')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📦 Gestion des Produits</h1>
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
        ← Dashboard
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-gray-600">Produit</th>
                <th class="px-4 py-3 text-left text-gray-600">Vendeur</th>
                <th class="px-4 py-3 text-left text-gray-600">Catégorie</th>
                <th class="px-4 py-3 text-left text-gray-600">Prix</th>
                <th class="px-4 py-3 text-left text-gray-600">Stock</th>
                <th class="px-4 py-3 text-left text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $product->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $product->title }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $product->user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $product->category->name }}</td>
                    <td class="px-4 py-3 font-semibold text-indigo-600">
                        {{ number_format($product->price, 2) }} TND
                    </td>
                    <td class="px-4 py-3">{{ $product->stock }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}"
                                class="bg-gray-100 text-gray-700 px-3 py-1 rounded hover:bg-gray-200 text-sm">
                                Voir
                            </a>
                            <form method="POST" action="{{ route('admin.products.delete', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Supprimer ce produit ?')"
                                    class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 text-sm">
                                    🗑️
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
@endsection