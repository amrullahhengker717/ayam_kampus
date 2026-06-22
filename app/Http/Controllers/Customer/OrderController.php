<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = auth()->user()->bookings()->with(['product.seller'])->latest();
        
        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }
        
        $orders = $query->paginate(10);
        
        return view('orders.index', compact('orders', 'status'));
    }
}
