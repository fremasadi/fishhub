@extends('front.frontapp')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold" style="color: var(--primary-blue);">
                    <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                </h2>
                <a href="{{ url('/#stok-benih') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Lanjut Belanja
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(empty($cart))
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                        <h4 class="text-muted">Keranjang Anda Kosong</h4>
                        <p class="text-muted mb-4">Belum ada item yang ditambahkan ke keranjang</p>
                        <a href="{{ url('/#stok-benih') }}" class="btn btn-primary">
                            <i class="fas fa-fish"></i> Lihat Stok Benih
                        </a>
                    </div>
                </div>
            @else
                <!-- Info Peternak -->
                <div class="alert alert-info d-flex align-items-center mb-4">
                    <i class="fas fa-info-circle fa-2x me-3"></i>
                    <div>
                        <strong>Pesanan dari Peternak:</strong> {{ $peternakName }}<br>
                        <small>Semua item dalam keranjang ini berasal dari peternak yang sama</small>
                    </div>
                </div>

                <!-- Alert Minimal Order -->
                <div class="alert alert-warning d-flex align-items-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <strong>Perhatian!</strong> Minimal pemesanan adalah <strong>100 ekor</strong> per jenis benih.<br>
                        <small>Anda dapat menambah jumlah di halaman ini (kelipatan 10 ekor)</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-list"></i> Daftar Item ({{ count($cart) }})
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($cart as $id => $item)
                                <div class="cart-item border-bottom p-3" id="cart-item-{{ $id }}">
                                    <div class="row align-items-center">
                                        <!-- Gambar -->
                                        <div class="col-md-2">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     class="img-fluid rounded" 
                                                     alt="{{ $item['jenis'] }}">
                                            @else
                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                     style="height: 80px;">
                                                    <i class="fas fa-fish fa-2x text-white"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Info Produk -->
                                        <div class="col-md-4">
                                            <h6 class="fw-bold mb-1">{{ $item['jenis'] }}</h6>
                                            <small class="text-muted">
                                                <span class="badge bg-primary">{{ $item['ukuran'] }}</span>
                                                <span class="badge bg-success">{{ $item['kualitas'] }}</span>
                                            </small>
                                            <p class="mb-0 mt-2 text-muted small">
                                                Rp {{ number_format($item['harga'], 0, ',', '.') }} / ekor
                                            </p>
                                        </div>

                                        <!-- Jumlah -->
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Jumlah (ekor):</label>
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" 
                                                        type="button" 
                                                        onclick="updateQuantity('{{ $id }}', -10, {{ $item['stok_tersedia'] }})">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" 
                                                       class="form-control text-center" 
                                                       id="qty-{{ $id }}"
                                                       value="{{ $item['jumlah'] }}" 
                                                       min="100" 
                                                       step="10"
                                                       max="{{ $item['stok_tersedia'] }}"
                                                       onchange="updateQuantityManual('{{ $id }}', {{ $item['stok_tersedia'] }})">
                                                <button class="btn btn-outline-secondary" 
                                                        type="button"
                                                        onclick="updateQuantity('{{ $id }}', 10, {{ $item['stok_tersedia'] }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                Stok: {{ number_format($item['stok_tersedia']) }} ekor
                                            </small>
                                            <small class="text-info d-block">
                                                Min: 100 | Step: 10
                                            </small>
                                        </div>

                                        <!-- Subtotal & Hapus -->
                                        <div class="col-md-3 text-end">
                                            <h6 class="fw-bold text-primary mb-2" id="subtotal-{{ $id }}">
                                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                            </h6>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="removeItem('{{ $id }}')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tombol Kosongkan Keranjang -->
                        <div class="text-end mt-3">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm sticky-top" style="top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-calculator"></i> Ringkasan Belanja
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Item:</span>
                                    <strong>{{ count($cart) }} jenis</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Ekor:</span>
                                    <strong>{{ number_format(array_sum(array_column($cart, 'jumlah'))) }} ekor</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal Benih:</span>
                                    <strong id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </div>

                                <hr>

                                <!-- Pilihan Pengiriman -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">
                                        <i class="fas fa-truck"></i> Pilihan Pengiriman
                                    </label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check border rounded p-2 ps-4">
                                            <input class="form-check-input" type="radio"
                                                   name="jenis_pengiriman_preview"
                                                   id="opt_ambil"
                                                   value="ambil_sendiri"
                                                   checked
                                                   onchange="togglePengiriman(this.value)">
                                            <label class="form-check-label" for="opt_ambil">
                                                <strong>Ambil Sendiri</strong>
                                                <small class="text-muted d-block">Langsung ke lokasi peternak — Gratis</small>
                                            </label>
                                        </div>
                                        <div class="form-check border rounded p-2 ps-4">
                                            <input class="form-check-input" type="radio"
                                                   name="jenis_pengiriman_preview"
                                                   id="opt_diantar"
                                                   value="diantar"
                                                   onchange="togglePengiriman(this.value)">
                                            <label class="form-check-label" for="opt_diantar">
                                                <strong>Diantar ke Alamat Saya</strong>
                                                <small class="text-muted d-block">+ Ongkir Rp 10.000</small>
                                            </label>
                                        </div>
                                    </div>

                                    <div id="box-alamat" class="mt-2 d-none">
                                        <label class="form-label small fw-semibold">Alamat Pengiriman:</label>
                                        <textarea id="input-alamat" rows="3"
                                                  class="form-control form-control-sm"
                                                  oninput="syncAlamat(this.value)"
                                                  placeholder="Alamat lengkap pengiriman...">{{ $alamatPembudidaya }}</textarea>
                                        <small class="text-muted">Default: alamat profil Anda</small>
                                    </div>
                                </div>

                                <!-- Row ongkir -->
                                <div class="d-flex justify-content-between mb-2 d-none" id="row-ongkir">
                                    <span>Ongkir:</span>
                                    <strong class="text-warning">+ Rp 10.000</strong>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">Total Bayar:</h5>
                                    <h5 class="mb-0 text-success" id="grand-total-final">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </h5>
                                </div>

                                <div class="d-grid gap-2">
                                    <form action="{{ route('payment.checkout') }}" method="POST" id="form-checkout">
                                        @csrf
                                        <input type="hidden" name="jenis_pengiriman" id="hidden-jenis" value="ambil_sendiri">
                                        <input type="hidden" name="alamat_pengiriman" id="hidden-alamat" value="{{ $alamatPembudidaya }}">
                                        <button type="submit" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-check-circle"></i> Checkout
                                        </button>
                                    </form>

                                    <a href="{{ url('/#stok-benih') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left"></i> Lanjut Belanja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
<script>
const baseTotal = {{ $total }};
const ongkirValue = 10000;

function togglePengiriman(value) {
    const boxAlamat = document.getElementById('box-alamat');
    const rowOngkir = document.getElementById('row-ongkir');
    const hiddenJenis = document.getElementById('hidden-jenis');
    const grandTotalFinal = document.getElementById('grand-total-final');

    hiddenJenis.value = value;

    if (value === 'diantar') {
        boxAlamat.classList.remove('d-none');
        rowOngkir.classList.remove('d-none');
        grandTotalFinal.textContent = 'Rp ' + (baseTotal + ongkirValue).toLocaleString('id-ID');
    } else {
        boxAlamat.classList.add('d-none');
        rowOngkir.classList.add('d-none');
        grandTotalFinal.textContent = 'Rp ' + baseTotal.toLocaleString('id-ID');
    }
}

function syncAlamat(value) {
    document.getElementById('hidden-alamat').value = value;
}

function updateQuantity(cartId, change, maxStock) {
    const qtyInput = document.getElementById('qty-' + cartId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + change;

    // Minimal 100 ekor
    if (newQty < 100) {
        alert('Minimal pemesanan adalah 100 ekor!');
        return;
    }

    // Maksimal stok tersedia
    if (newQty > maxStock) {
        alert('Stok tidak mencukupi! Maksimal: ' + maxStock.toLocaleString('id-ID') + ' ekor');
        return;
    }

    // Update via AJAX
    fetch(`/cart/${cartId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ jumlah: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = newQty;
            document.getElementById('subtotal-' + cartId).textContent = 
                'Rp ' + data.subtotal.toLocaleString('id-ID');
            document.getElementById('grand-total').textContent = 
                'Rp ' + data.total.toLocaleString('id-ID');
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function updateQuantityManual(cartId, maxStock) {
    const qtyInput = document.getElementById('qty-' + cartId);
    let newQty = parseInt(qtyInput.value);

    if (newQty < 100) {
        alert('Minimal pemesanan adalah 100 ekor!');
        qtyInput.value = 100;
        return;
    }

    if (newQty > maxStock) {
        alert('Stok tidak mencukupi! Maksimal: ' + maxStock.toLocaleString('id-ID') + ' ekor');
        qtyInput.value = maxStock;
        newQty = maxStock;
    }

    // Update via AJAX
    fetch(`/cart/${cartId}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ jumlah: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('subtotal-' + cartId).textContent = 
                'Rp ' + data.subtotal.toLocaleString('id-ID');
            document.getElementById('grand-total').textContent = 
                'Rp ' + data.total.toLocaleString('id-ID');
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function removeItem(cartId) {
    if (!confirm('Yakin ingin menghapus item ini?')) {
        return;
    }

    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}
</script>
@endsection
@endsection