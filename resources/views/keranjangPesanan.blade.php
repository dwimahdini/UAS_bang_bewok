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

            {{--        @dd($keranjangPesanan)--}}
            @foreach($keranjangPesanan as $item)
                @php
                    $itemTotal = $item->produk->harga * $item->jumlah;
                    $totalPrice += $itemTotal;
                    $totalQuantity += $item->jumlah;
                @endphp

                <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
                    <img src="{{ asset('img/' . $item->produk->gambar) }}" alt="Gambar Produk"
                         class="w-16 h-16 object-cover mr-4">
                    <div class="flex-1 flex items-center justify-between">
                        <p class="text-gray-600 w-1/3 ml-2"><strong>Produk: {{ $item->produk->nama_produk }}</strong>
                        </p>
                        <p class="text-gray-600 w-1/3 text-center">Jumlah: {{ $item->jumlah }}</p>
                        <p class="text-gray-600 w-1/3 text-right mr-4">Total:
                            Rp {{ number_format($itemTotal, 2, ',', '.') }}</p>
                        <p class="text-gray-600 w-1/3 text-center">
                            Status:
                            <span
                                class="{{ $item->status->id === 1 ? 'bg-blue-200 text-blue-800' : ($item->status->id === 2 ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800') }} px-2 py-1 rounded">
                                    {{ $item->status->nama_status }}
                            </span>
                        </p>

                    </div>
                </div>
            @endforeach

            <!-- Total Price and Quantity Card -->
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
                <div class="flex-1 flex items-center justify-between">
                    <p class="text-gray-600 w-1/3 ml-2"><strong>Total Pesanan Anda</strong></p>
                    <p class="text-gray-600 w-1/3 text-center">Jumlah: {{ $totalQuantity }}</p>
                    <p class="text-gray-600 w-1/3 text-right mr-4">Total:
                        Rp {{ number_format($totalPrice, 2, ',', '.') }}</p>
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="processAllOrders()">Proses Semua
                    Pesanan
                </button>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        async function processAllOrders() {
            const orderIds = @json($keranjangPesanan->pluck('id'));

            if (orderIds.length === 0) {
                Swal.fire('Peringatan!', 'Tidak ada pesanan untuk diproses.', 'warning');
                return;
            }

            try {
                const response = await fetch('/keranjangPesanan/processAllOrders', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({order_ids: orderIds})
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('Error response:', errorText);
                    throw new Error(`Network response was not ok: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();
                Swal.fire('Sukses!', data.message || 'Pesanan berhasil diproses.', 'success').then(() => {
                    location.reload();
                });
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Gagal!', error.message || 'Terjadi kesalahan pada server.', 'error');
            }
        }
    </script>
@endsection
