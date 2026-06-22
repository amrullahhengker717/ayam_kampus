<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'terbaru');
        
        $query = Promo::with(['product.seller'])->whereDate('end_date', '>=', now());
        
        if ($filter === 'diskon_terbesar') {
            $query->orderBy('discount_percentage', 'desc');
        } elseif ($filter === 'akan_berakhir') {
            $query->orderBy('end_date', 'asc');
        } else {
            $query->latest();
        }
        
        $promos = $query->paginate(12);
        
        return view('promo.index', compact('promos', 'filter'));
    }
}
