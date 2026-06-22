@extends('layouts.app')

@section('content')
<style>
    .booking-container {
        max-width: 800px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    @media (max-width: 768px) {
        .booking-container {
            grid-template-columns: 1fr;
        }
    }
    .product-summary {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        align-self: start;
    }
    .booking-form {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .product-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-dark);
    }
    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: var(--primary);
        outline: none;
    }
    .total-section {
        background: #f9f9f9;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 2rem;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    .total-row.grand-total {
        font-weight: 900;
        font-size: 1.5rem;
        color: var(--primary);
        border-top: 2px dashed #ddd;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        margin-top: 2rem;
        transition: transform 0.2s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
    }
</style>

<div style="max-width: 800px; margin: 0 auto 2rem;">
    <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">&larr; Kembali</a>
    <h2 style="margin-top: 1rem;">Detail Pemesanan</h2>
</div>

<div class="booking-container">
    <!-- Product Summary -->
    <div class="product-summary">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
        @else
            <div class="product-img">🍗</div>
        @endif
        
        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">{{ $product->name }}</h3>
        <p style="color: #666; margin-bottom: 1rem;">Penjual: <strong>{{ $product->seller->store_name }}</strong></p>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem;">
            Rp <span id="product-price">{{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
        <p style="color: #555; line-height: 1.6;">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
    </div>

    <!-- Booking Form -->
    <div class="booking-form">
        <form action="{{ route('booking.store', $product->id) }}" method="POST">
            @csrf

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <ul style="margin-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label>Jumlah Pesanan</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
            </div>

            <div class="form-group">
                <label>Catatan (Opsional)</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Misal: Jangan pakai sambal, dll.">{{ old('catatan') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div class="form-group" style="flex: 1;">
                    <label>Tanggal Ambil</label>
                    <input type="date" name="tanggal_ambil" class="form-control" value="{{ old('tanggal_ambil', date('Y-m-d')) }}" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Jam Ambil</label>
                    <input type="time" name="jam_ambil" class="form-control" value="{{ old('jam_ambil') }}" required>
                </div>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>Rp <span id="subtotal-display">{{ number_format($product->price, 0, ',', '.') }}</span></span>
                </div>
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span>Rp <span id="total-display">{{ number_format($product->price, 0, ',', '.') }}</span></span>
                </div>
            </div>

            <button type="submit" class="btn-submit">Buat Pesanan Sekarang</button>
        </form>
    </div>
</div>

<script>
    const price = {{ (int) $product->price }};
    const qtyInput = document.getElementById('quantity');
    const subtotalDisplay = document.getElementById('subtotal-display');
    const totalDisplay = document.getElementById('total-display');

    function formatRupiah(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    qtyInput.addEventListener('input', function() {
        let qty = parseInt(this.value) || 0;
        if(qty < 1) qty = 1;
        
        const total = price * qty;
        subtotalDisplay.innerText = formatRupiah(total);
        totalDisplay.innerText = formatRupiah(total);
    });
</script>
@endsection
