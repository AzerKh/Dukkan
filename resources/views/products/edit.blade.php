@extends('layouts.app')

@section('title', 'Modifier le produit')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">✏️ Modifier le produit</h1>

    <div class="bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Titre -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Titre *</label>
                <input type="text" name="title" value="{{ old('title', $product->title) }}"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description *</label>
                <textarea name="description" rows="4"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prix et Stock -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Prix (TND) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                        class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                        @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                        @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catégorie -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Catégorie *</label>
                <select name="category_id"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('category_id') border-red-500 @enderror">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image actuelle -->
            @if($product->image)
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Image actuelle</label>
                    <img src="{{ Storage::url($product->image) }}"
                        class="w-32 h-32 object-cover rounded">
                </div>
            @endif

            <!-- Nouvelle image -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Nouvelle image (optionnel)</label>
                <input type="file" name="image" accept="image/*"
                    class="border rounded px-3 py-2 w-full focus:outline-none focus:border-indigo-500
                    @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    ✏️ Modifier le produit
                </button>
                <a href="{{ route('products.index') }}"
                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection