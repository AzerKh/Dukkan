<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product.category')
            ->paginate(10);
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()
                ->with('success', 'Produit retiré de la wishlist !');
        }

        Wishlist::create([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        return redirect()->back()
            ->with('success', 'Produit ajouté à la wishlist !');
    }

    public function destroy(Product $product)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'Produit retiré de la wishlist !');
    }
}