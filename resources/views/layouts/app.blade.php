<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dukkan - @yield('title', 'Accueil')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-text {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }
        .nav-link { position: relative; transition: color 0.3s; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s;
        }
        .nav-link:hover::after { width: 100%; }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }
        .badge { animation: pulse 2s infinite; }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .dropdown-menu { display: none; animation: fadeIn 0.2s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .group:hover .dropdown-menu { display: block; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Navbar -->
    <nav class="gradient-bg shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-xl">🏪</span>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">Dukkan</span>
                        <span class="text-xs text-yellow-300 block -mt-1">دكان</span>
                    </div>
                </a>

                <!-- Search -->
                <form method="GET" action="{{ route('home') }}" class="flex-1 mx-8 max-w-xl">
                    <div class="flex rounded-xl overflow-hidden shadow-lg">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Rechercher un produit..."
                            class="w-full px-4 py-2.5 text-gray-800 focus:outline-none text-sm">
                        <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 px-5 py-2.5 transition font-bold text-gray-900">
                            🔍
                        </button>
                    </div>
                </form>

                <!-- Actions -->
                <div class="flex items-center gap-5">
                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative text-white nav-link">
                            <div class="flex flex-col items-center">
                                <span class="text-2xl">🛒</span>
                                <span class="text-xs">Panier</span>
                            </div>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge absolute -top-1 -right-1 bg-yellow-400 text-gray-900 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>

                        <!-- Wishlist -->
                        <a href="{{ route('wishlist.index') }}" class="text-white nav-link">
                            <div class="flex flex-col items-center">
                                <span class="text-2xl">❤️</span>
                                <span class="text-xs">Wishlist</span>
                            </div>
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-xl transition">
                                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-gray-900 font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                <span class="text-xs">▾</span>
                            </button>
                            <div class="dropdown-menu absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                                <div class="gradient-bg px-4 py-3">
                                    <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-white opacity-75">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <span>⚙️</span> Gérer mon compte
                                    </a>
                                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <span>🏪</span> Mes produits
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                        <span>📦</span> Mes commandes
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <hr class="my-1">
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition font-medium">
                                            <span>⚙️</span> Dashboard Admin
                                        </a>
                                    @endif
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-red-500 hover:bg-red-50 transition">
                                            <span>🚪</span> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white nav-link font-medium">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-yellow-400 hover:bg-yellow-300 text-gray-900 px-5 py-2.5 rounded-xl font-bold transition shadow-lg">
                            S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Sub Nav -->
        <div class="border-t border-white border-opacity-20">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center gap-6 py-2 text-sm text-white">
                    <a href="{{ route('home') }}" class="nav-link opacity-90 hover:opacity-100">🏠 Accueil</a>
                    <a href="{{ route('home') }}?sort=newest" class="nav-link opacity-90 hover:opacity-100">🆕 Nouveautés</a>
                    <a href="{{ route('home') }}?sort=price_asc" class="nav-link opacity-90 hover:opacity-100">💰 Meilleurs prix</a>
                    @auth
                        <a href="{{ route('products.create') }}" class="nav-link opacity-90 hover:opacity-100">➕ Vendre</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2 shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center gap-2 shadow-sm">
                ❌ {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="gradient-bg text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <span class="text-xl">🏪</span>
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold block">Dukkan</span>
                            <span class="text-xs text-yellow-300">دكان</span>
                        </div>
                    </div>
                    <p class="text-white text-opacity-75 text-sm leading-relaxed">
                        La meilleure plateforme e-commerce de Tunisie. Achetez et vendez en toute sécurité.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-yellow-300">Acheteurs</h4>
                    <ul class="space-y-2 text-sm text-white text-opacity-75">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Catalogue</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-white transition">Mes commandes</a></li>
                            <li><a href="{{ route('wishlist.index') }}" class="hover:text-white transition">Ma wishlist</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-yellow-300">Vendeurs</h4>
                    <ul class="space-y-2 text-sm text-white text-opacity-75">
                        @auth
                            <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Mes produits</a></li>
                            <li><a href="{{ route('products.create') }}" class="hover:text-white transition">Vendre un produit</a></li>
                        @else
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Créer un compte</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-yellow-300">Contact</h4>
                    <ul class="space-y-2 text-sm text-white text-opacity-75">
                        <li>📧 contact@dukkan.tn</li>
                        <li>📞 +216 71 000 000</li>
                        <li>📍 Tunis, Tunisie</li>
                    </ul>
                </div>
            </div>
            <hr class="border-white border-opacity-20 my-8">
            <div class="text-center text-white text-opacity-60 text-sm">
                © 2026 Dukkan دكان — Tous droits réservés | Développé avec ❤️ en Laravel
            </div>
        </div>
    </footer>

</body>
</html>