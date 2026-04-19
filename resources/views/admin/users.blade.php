@extends('layouts.app')

@section('title', 'Gestion Utilisateurs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">👥 Gestion des Utilisateurs</h1>
    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
        ← Dashboard
    </a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-gray-600">Nom</th>
                <th class="px-4 py-3 text-left text-gray-600">Email</th>
                <th class="px-4 py-3 text-left text-gray-600">Rôle</th>
                <th class="px-4 py-3 text-left text-gray-600">Inscrit le</th>
                <th class="px-4 py-3 text-left text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $user->id }}</td>
                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('admin.users.toggleRole', $user) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded hover:bg-indigo-200 text-sm">
                                    {{ $user->role === 'admin' ? '👤 User' : '⚙️ Admin' }}
                                </button>
                            </form>
                            @if($user->id !== Auth::id())
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Supprimer cet utilisateur ?')"
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 text-sm">
                                        🗑️
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
<div class="mt-4">{{ $users->links() }}</div>
@endsection