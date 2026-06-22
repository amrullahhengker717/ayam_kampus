<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::all();
        $promos = Promo::with('product.seller')->latest()->take(5)->get();

        $productsQuery = Product::with(['seller', 'category'])->latest();

        if ($search) {
            $productsQuery->where('name', 'like', '%' . $search . '%')
                          ->orWhereHas('seller', function($q) use ($search) {
                              $q->where('store_name', 'like', '%' . $search . '%');
                          });
        }

        $products = $productsQuery->paginate(8);

        if ($request->ajax()) {
            return view('components.product-list', compact('products'))->render();
        }

        return view('home', compact('categories', 'promos', 'products', 'search'));
    }
}
