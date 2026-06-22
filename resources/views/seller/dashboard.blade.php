@extends('layouts.seller')

@section('content')
    <h2 style="margin-bottom: 1.5rem;">Selamat Datang, {{ $seller->store_name }}!</h2>

    <div style="display: flex; gap: 1.5rem;">
        <div class="card" style="flex: 1; text-align: center;">
            <h3 style="color: #666;">Total Produk</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">{{ $productCount }}</p>
        </div>
        <div class="card" style="flex: 1; text-align: center;">
            <h3 style="color: #666;">Promo Aktif</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: var(--secondary);">{{ $promoCount }}</p>
        </div>
        <div class="card" style="flex: 1; text-align: center;">
            <h3 style="color: #666;">Total Pesanan</h3>
            <p style="font-size: 2.5rem; font-weight: 800; color: #28a745;">0</p>
        </div>
    </div>
@endsection
