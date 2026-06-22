<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Product $product)
    {
        return view('booking.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'tanggal_ambil' => 'required|date|after_or_equal:today',
            'jam_ambil' => 'required',
        ]);

        $totalPrice = $product->price * $request->quantity;

        Booking::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'catatan' => $request->catatan,
            'tanggal_ambil' => $request->tanggal_ambil,
            'jam_ambil' => $request->jam_ambil,
            'status' => 'menunggu',
        ]);

        return redirect()->route('home')->with('success', 'Booking berhasil dibuat! Silakan tunggu konfirmasi penjual.');
    }
}
