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
                    <th class="py-2 px-4 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $order->produk->nama_produk }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $order->jumlah }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">Rp {{ number_format($order->total_harga, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $order->tanggal_pesanan }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center border-r border-gray-300">{{ $order->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection