@extends('layouts.sidebar')
@section('title', 'Keranjang Staf')
@vite('resources/css/app.css')

@section('content')
<div class="container mx-auto mt-8">
    <!-- Filter Tanggal -->
    <div class="flex items-center justify-between mb-4 border border-grey-500 p-4 rounded">
        <div class="w-1/3">
            <label for="from_date" class="block text-sm font-medium text-gray-700">Tanggal Dari:</label>
            <input type="date" id="from_date" name="from_date" class="mt-5 block w-full border border-grey-900 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-lg" required>
        </div>
        <div class="w-1/3">
            <label for="to_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal:</label>
            <input type="date" id="to_date" name="to_date" class="mt-5 block w-full border border-grey-900 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-lg" required>
        </div>
        <div class="w-1/6 flex flex-col items-end space-y-2">
            <form class="w-full px-0.9 py-1"  action="{{ route('laporan.index') }}" method="GET">
                <button class="w-full px-4 py-1 bg-green-600 text-white rounded-md shadow hover:bg-green-700"
                        style="background-color: #5D5108; color: white;"
                        onmouseover="this.style.backgroundColor='#C3AB12'"
                        onmouseout="this.style.backgroundColor='#5D5108'"
                        id="filterButton"
                        type="submit">
                    Filter
                </button>
            </form>
            <button class="w-full px-1 py-1 bg-green-600 text-white rounded-md shadow hover:bg-green-700"
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
                @foreach($data as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->produk->nama_produk }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 text-center">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 text-center">{{ $item->created_at->translatedFormat('d F Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 text-center">{{ $item->status->nama_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total Harga dan Total Produk -->
    <div class="flex flex-col md:flex-row justify-between">
        <div class="border border-green-500 rounded p-4 w-full md:w-1/4 mb-4" style="   background-color: #C3AB12;">
            <span class="block text-white font-medium">Total Produk:</span>
            <span id="totalProduk" class="text-lg text-white font-semibold ">{{ $totalProduk }}</span>
        </div>
    </div>
    <div class="flex flex-col md:flex-row justify-between">
        <div class="border border-green-500 rounded p-4 w-full md:w-1/4 mb-4" style="background-color: #C3AB12;">
            <span class="block text-white font-medium">Total Harga:</span>
            <span id="totalHarga" class="text-lg text-white font-semibold">Rp. {{ number_format(  $totalHarga, 0, '', '.') }}</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fromDateInput = document.getElementById("from_date");
        const toDateInput = document.getElementById("to_date");
        const filterButton = document.getElementById("filterButton");
        const rows = document.querySelectorAll("#riwayatPesananBody tr");

        filterButton.addEventListener("click", function (event) {
            event.preventDefault();

            const fromDate = new Date(fromDateInput.value);
            const toDate = new Date(toDateInput.value);

            rows.forEach(row => {
                const dateCell = row.querySelector("td:nth-child(4)");
                const rowDate = new Date(dateCell.textContent.trim());
                if (rowDate >= fromDate && rowDate <= toDate) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });

</script>
@endsection
