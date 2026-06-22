@extends('layouts.app')

@section('content')
<style>
    .orders-container {
        max-width: 900px;
        margin: 0 auto 3rem;
    }
    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    .filter-tab {
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        background: white;
        color: #555;
        text-decoration: none;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid #ddd;
        transition: all 0.2s;
    }
    .filter-tab:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    .filter-tab.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    .order-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    .order-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }
    .order-details {
        flex: 1;
        min-width: 250px;
    }
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: bold;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    .status-menunggu { background: #fff3cd; color: #856404; }
    .status-diproses { background: #cce5ff; color: #004085; }
    .status-selesai { background: #d4edda; color: #155724; }
    .status-dibatalkan { background: #f8d7da; color: #721c24; }
    
    .order-meta {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    .order-meta strong {
        color: #333;
    }
    .order-total {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
        margin-top: 0.5rem;
    }

    @media (max-width: 600px) {
        .order-card {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }
        .order-img {
            width: 100%;
            height: 180px;
        }
        .order-details { min-width: 100%; }
    }
</style>

<div class="orders-container">
    <h2 style="margin-bottom: 1.5rem;">Riwayat Pesanan</h2>

    <!-- Filters -->
    <div class="filter-tabs">
        <a href="{{ route('orders.index', ['status' => 'semua']) }}" class="filter-tab {{ (request('status') == 'semua' || !request('status')) ? 'active' : '' }}">Semua</a>
        <a href="{{ route('orders.index', ['status' => 'menunggu']) }}" class="filter-tab {{ request('status') == 'menunggu' ? 'active' : '' }}">Menunggu</a>
        <a href="{{ route('orders.index', ['status' => 'diproses']) }}" class="filter-tab {{ request('status') == 'diproses' ? 'active' : '' }}">Diproses</a>
        <a href="{{ route('orders.index', ['status' => 'selesai']) }}" class="filter-tab {{ request('status') == 'selesai' ? 'active' : '' }}">Selesai</a>
        <a href="{{ route('orders.index', ['status' => 'dibatalkan']) }}" class="filter-tab {{ request('status') == 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
    </div>

    <!-- Orders List -->
    <div>
        @forelse($orders as $order)
            <div class="order-card">
                @if($order->product && $order->product->image)
                    <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" class="order-img">
                @else
                    <div class="order-img">🍗</div>
                @endif

                <div class="order-details">
                    <span class="status-badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span>
                    <h3 style="margin-bottom: 0.5rem;">{{ $order->product->name ?? 'Produk Tidak Tersedia' }}</h3>
                    
                    <div class="order-meta">
                        Penjual: <strong>{{ $order->product->seller->store_name ?? '-' }}</strong><br>
                        Tanggal Ambil: <strong>{{ \Carbon\Carbon::parse($order->tanggal_ambil)->format('d M Y') }}</strong> Jam: <strong>{{ \Carbon\Carbon::parse($order->jam_ambil)->format('H:i') }}</strong><br>
                        Jumlah: <strong>{{ $order->quantity }} porsi</strong>
                    </div>
                    
                    @if($order->catatan)
                        <div style="background: #f9f9f9; padding: 0.8rem; border-radius: 8px; font-size: 0.9rem; color: #555; margin-bottom: 0.5rem; font-style: italic;">
                            "{{ $order->catatan }}"
                        </div>
                    @endif

                    <div class="order-total">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px;">
                <h3 style="color: #666; margin-bottom: 1rem;">Belum ada pesanan</h3>
                <p style="color: #999; margin-bottom: 1.5rem;">Ayo mulai cari makanan favoritmu di kampus!</p>
                <a href="{{ route('home') }}" style="display: inline-block; padding: 0.8rem 1.5rem; background: var(--primary); color: white; border-radius: 50px; text-decoration: none; font-weight: bold;">Cari Makanan</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
