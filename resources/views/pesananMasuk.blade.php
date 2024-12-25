@extends('layouts.sidebar')
@section('title', 'Pesanan Masuk')
@vite('resources/css/app.css')

@section('content')
<div class="p-1 md:p-1 font-inter">
    <h1 class="text-2xl font-bold mb-4">Pesanan Masuk</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg border border-gray-300">
            <thead style="background-color: #C3AB12;">
                <tr>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">No</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Nama Produk</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Jumlah</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Total Harga</th>
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjangPesanan as $item)
                <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->produk->nama_produk }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->jumlah }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">Rp {{ number_format($item->produk->harga * $item->jumlah, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Buttons below the table -->
    <div class="mt-4 flex justify-between space-x-4 w-full">
        <button class="bg-green-500 text-white px-4 py-2 rounded w-1/3" onclick="processAllOrders()">Proses Pesanan</button>
        <button class="bg-blue-500 text-white px-4 py-2 rounded w-1/3" onclick="approveAllOrders()">Terima Pesanan</button>
        <button class="bg-red-500 text-white px-4 py-2 rounded w-1/3" onclick="rejectAllOrders()">Tolak Pesanan</button>
    </div>
</div>

<script>
    function processAllOrders() {
        // Implement the logic to process all orders
        fetch('/keranjang/process', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Processing all orders');
            location.reload();
        });
    }

    function approveAllOrders() {
        // Implement the logic to approve all orders
        fetch('/keranjang/approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Approving all orders');
            location.reload();
        });
    }

    function rejectAllOrders() {
        // Implement the logic to reject all orders
        console.log('Rejecting all orders');
    }
</script>
@endsection