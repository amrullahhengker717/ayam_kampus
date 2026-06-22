<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = auth()->user()->seller;
        $productCount = $seller->products()->count();
        $promoCount = \App\Models\Promo::whereHas('product', function($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->count();

        return view('seller.dashboard', compact('seller', 'productCount', 'promoCount'));
    }
}
