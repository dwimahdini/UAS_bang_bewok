@extends('layouts.sidebar')
@section('title', 'Keranjang Pesanan')
@vite('resources/css/app.css')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Pesanan Produk Anda</h1>
    <div class="grid grid-cols-1 gap-4">
        @php
            $totalPrice = 0;
            $totalQuantity = 0;
        @endphp

        @foreach($keranjangPesanan as $item)
        @php
            $itemTotal = $item->produk->harga * $item->jumlah;
            $totalPrice += $itemTotal;
            $totalQuantity += $item->jumlah;
        @endphp
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <img src="{{ asset('img/' . $item->produk->gambar) }}" alt="Gambar Produk" class="w-16 h-16 object-cover mr-4">
            <div class="flex-1 flex items-center justify-between">
                <p class="text-gray-600 w-1/3 ml-2"><strong>Produk : {{ $item->produk->nama_produk }}</strong></p>
                <p class="text-gray-600 w-1/3 text-center">Jumlah: {{ $item->jumlah }}</p>
                <p class="text-gray-600 w-1/3 text-right mr-4">Total: Rp {{ number_format($itemTotal, 2, ',', '.') }}</p>
            </div>
            <button class="bg-red-500 text-white px-4 py-2 rounded" onclick="batalPesanan({{ $item->id }})">Batal</button>
        </div>
        @endforeach

        <!-- Total Price and Quantity Card -->
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div class="flex-1 flex items-center justify-between">
                <p class="text-gray-600 w-1/3 ml-2"><strong>Total Produk</strong></p>
                <p class="text-gray-600 w-1/3 text-center">Jumlah: {{ $totalQuantity }}</p>
                <p class="text-gray-600 w-1/3 text-right mr-4">Total: Rp {{ number_format($totalPrice, 2, ',', '.') }}</p>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="processOrder()">Proses Pesanan</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showLoading() {
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your order.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function batalPesanan(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan tindakan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak, tetap simpan'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/keranjang/${id}/batal`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'Dibatalkan!',
                            'Produk telah dibatalkan.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat membatalkan pesanan.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan pada server.',
                        'error'
                    );
                });
            }
        });
    }

    function processOrder() {
        Swal.fire({
            title: 'Proses Pesanan',
            text: "Apakah Anda ingin memproses pesanan ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, proses!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                fetch('/process-order', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire(
                        'Diproses!',
                        'Pesanan Anda sedang diproses.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat memproses pesanan.',
                        'error'
                    );
                });
            }
        });
    }
</script>
@endsection
