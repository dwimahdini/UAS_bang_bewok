@extends('layouts.sidebar')
@section('title', 'Keranjang Staf')
@vite('resources/css/app.css')

@section('content')
<div class="container mx-auto mt-8">
    <!-- Filter Tanggal -->
    <div class="flex items-center justify-between mb-4 border border-grey-500 p-4 rounded">
        <div class="w-1/3">
            <label for="from_date" class="block text-sm font-medium text-gray-700">Tanggal Dari:</label>
            <input type="date" id="from_date" name="from_date" class="mt-5 block w-full border border-grey-900 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-lg">
        </div>
        <div class="w-1/3">
            <label for="to_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal:</label>
            <input type="date" id="to_date" name="to_date" class="mt-5 block w-full border border-grey-900 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-lg">
        </div>
        <div class="w-1/6 flex flex-col items-end space-y-2">
            <button class="w-full px-2 py-1 bg-green-600 text-white rounded-md shadow hover:bg-green-700" 
                    style="background-color: #5D5108; color: white;" 
                    onmouseover="this.style.backgroundColor='#C3AB12'" 
                    onmouseout="this.style.backgroundColor='#5D5108'" 
                    id="filterButton">
                Filter
            </button>
            <button class="w-full px-2 py-1 bg-green-600 text-white rounded-md shadow hover:bg-green-700" 
                    style="background-color: #84cc16; color: white;" 
                    onmouseover="this.style.backgroundColor='#15803d'" 
                    onmouseout="this.style.backgroundColor='#84cc16'" 
                    id="printButton">
                Cetak
            </button>
        </div>        
    </div>

    <!-- Tabel Riwayat Pesanan -->
    <div class="border border-grey-500 rounded p-4 mb-4">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg border border-gray-300">
            <thead style="background-color: #C3AB12;">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">No</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Nama Produk</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Jumlah</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody id="riwayatPesananBody" class="bg-white divide-y divide-gray-200">
                <!-- Baris data dummy -->
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-700">1</td>
                    <td class="px-6 py-4 text-sm text-gray-700">Produk A</td>
                    <td class="px-6 py-4 text-sm text-gray-700">5</td>
                    <td class="px-6 py-4 text-sm text-gray-700">28 September 2024</td>
                    <td class="px-6 py-4 text-sm text-gray-700">disetujui</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-700">2</td>
                    <td class="px-6 py-4 text-sm text-gray-700">Produk B</td>
                    <td class="px-6 py-4 text-sm text-gray-700">3</td>
                    <td class="px-6 py-4 text-sm text-gray-700">2 November 2024</td>
                    <td class="px-6 py-4 text-sm text-gray-700">disetujui</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-700">3</td>
                    <td class="px-6 py-4 text-sm text-gray-700">Produk C</td>
                    <td class="px-6 py-4 text-sm text-gray-700">10</td>
                    <td class="px-6 py-4 text-sm text-gray-700">28 Januari 2024</td>
                    <td class="px-6 py-4 text-sm text-gray-700">disetujui</td>
                </tr>
                <!-- Baris data akan diisi melalui script dinamis -->
            </tbody>
        </table>
    </div>

    <!-- Total Harga dan Total Produk -->
    <div class="flex flex-col md:flex-row justify-between">
        <div class="border border-green-500 rounded p-4 w-full md:w-1/4 mb-4" style="background-color: #C3AB12;">
            <span class="block text-brown-700 font-medium">Total Produk:</span>
            <span id="totalProduk" class="text-lg font-semibold ">0</span>
        </div>
    </div>
    <div class="flex flex-col md:flex-row justify-between">
        <div class="border border-green-500 rounded p-4 w-full md:w-1/4 mb-4" style="background-color: #C3AB12;">
            <span class="block text-brown-700 font-medium">Total Harga:</span>
            <span id="totalHarga" class="text-lg font-semibold">Rp 0</span>
        </div>
    </div>
</div>

<script>
    document.getElementById('filterButton').addEventListener('click', function() {
        const fromDate = document.getElementById('from_date').value;
        const toDate = document.getElementById('to_date').value;

        // Validasi tanggal
        if (!fromDate || !toDate) {
            alert('Silakan pilih tanggal dari dan sampai.');
            return;
        }

        // Fetch data sesuai tanggal dari backend
        fetch(`/api/riwayat-pesanan?from_date=${fromDate}&to_date=${toDate}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('riwayatPesananBody');
                tbody.innerHTML = '';

                let totalProduk = 0;
                let totalHarga = 0;

                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 text-sm text-gray-700">${index + 1}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${item.nama_produk}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${item.jumlah}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${item.tanggal}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">${item.status}</td>
                    `;
                    tbody.appendChild(row);

                    totalProduk += item.jumlah;
                    totalHarga += item.harga;
                });

                document.getElementById('totalProduk').textContent = totalProduk;
                document.getElementById('totalHarga').textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Terjadi kesalahan saat mengambil data.');
            });
    });
</script>
@endsection