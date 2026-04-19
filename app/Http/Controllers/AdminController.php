<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'    => User::count(),
            'products' => Product::count(),
            'orders'   => Order::count(),
            'revenue'  => Order::where('status', 'validee')->sum('total_price'),
            'pending'  => Order::where('status', 'en_attente')->count(),
        ];
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentUsers  = User::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    public function toggleRole(User $user)
    {
        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin'
        ]);
        return redirect()->back()->with('success', 'Rôle modifié !');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé !');
    }

    public function products()
    {
        $products = Product::with(['user', 'category'])->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Produit supprimé !');
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:en_attente,validee,annulee'
        ]);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Statut mis à jour !');
    }
}