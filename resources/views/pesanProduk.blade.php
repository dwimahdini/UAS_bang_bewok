@extends('layouts.sidebar')
@section('title', 'Pesan Produk')
@vite('resources/css/app.css')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Pesan Produk</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach($produk as $p)
        @php
            $currentDate = \Carbon\Carbon::now();
            $expiryDate = \Carbon\Carbon::parse($p->tanggal_kadaluarsa);
            $daysRemaining = $expiryDate->diffInDays($currentDate);

            // Tentukan status kedaluwarsa
            $statusKedalursa = $daysRemaining < 0 ? 'Kedaluwarsa' : ($daysRemaining <= 3 ? 'Mendekati' : 'Aman');
        @endphp
        <div class="bg-white rounded-lg shadow-md p-2 flex flex-col min-h-64">
            <img src="{{ asset('img/' . $p->gambar) }}" alt="Gambar Produk" class="w-full h-50 object-cover rounded-lg mb-2">
            <h2 class="text-lg font-semibold">{{ $p->nama_produk }}</h2>
            <p class="text-gray-600">Harga: Rp {{ number_format($p->harga, 2, ',', '.') }}</p>
            <p id="product-quantity-{{ $p->id }}" class="text-gray-600">Jumlah: {{ $p->jumlah }}</p>
            <p class="text-gray-600">Tanggal Kadaluwarsa: {{ $expiryDate->format('Y-m-d') }}</p>
            <p class="text-gray-600">
                <span class="font-bold {{ $statusKedalursa == 'Kedaluwarsa' ? 'text-red-500' : ($statusKedalursa == 'Mendekati' ? 'text-yellow-500' : 'text-green-500') }}">
                    {{ $statusKedalursa }}
                </span>
            </p>
            <div class="mt-auto">
                <button onclick="pesanProduk({{ $p->id }})" class="mt-2 bg-[#5D5108] text-white px-2 py-1 rounded-lg">Pesan</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal for Quantity Input -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg p-4 w-full max-w-md">
        <h2 class="text-lg font-semibold mb-2 text-center">Pesan Produk</h2>
        <div id="orderContent">
            <p id="productName"></p>
            <p id="productPrice"></p>
            <label for="quantity" class="block mt-2">Jumlah:</label>
            <input type="number" id="quantityInput" class="border border-gray-300 rounded-lg w-full p-2" min="1" value="1">
            <p id="remainingQuantity" class="mt-2 text-gray-600"></p>
        </div>
        <div class="flex justify-between mt-4">
            <button type="button" onclick="closeOrderModal()" class="bg-red-500 text-white px-4 py-2 rounded-lg">Batal</button>
            <button type="button" onclick="confirmOrder()" class="bg-green-500 text-white px-4 py-2 rounded-lg">Pesan</button>
        </div>
    </div>
</div>

<script>
    let selectedProductId;

    // Fungsi untuk membuka modal
    function openOrderModal(productId, productName, productPrice) {
        selectedProductId = productId;
        document.getElementById("productName").innerText = `Nama Produk: ${productName}`;
        document.getElementById("productPrice").innerText = `Harga: Rp ${productPrice.toLocaleString()}`;
        document.getElementById("orderModal").classList.remove("hidden");
    }

    // Fungsi untuk menutup modal
    function closeOrderModal() {
        document.getElementById("orderModal").classList.add("hidden");
    }

    // Fungsi untuk mengkonfirmasi pesanan
    function confirmOrder() {
        const quantity = document.getElementById("quantityInput").value;

        fetch('/pesan-produk/tambah-ke-keranjang', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                productId: selectedProductId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.success,
                    confirmButtonText: 'OK'
                }).then(() => {
                    closeOrderModal(); // Close the modal
                    location.reload(); // Reload the page to see updated quantities
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.error,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat memproses pesanan.',
                confirmButtonText: 'OK'
            });
        });
    }

    // Fungsi pesanProduk yang diperbaiki
    function pesanProduk(productId) {
        // Fetch product details
        fetch(`/produk/${productId}`)
            .then(response => response.json())
            .then(data => {
                // Set product details in the modal
                openOrderModal(productId, data.nama_produk, data.harga);
                document.getElementById("remainingQuantity").innerText = `Sisa Produk: ${data.jumlah}`; // Set remaining quantity
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
            });
    }
</script>
@endsection