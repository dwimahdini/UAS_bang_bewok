@extends('layouts.sidebar')
@section('title', 'Beranda')

@section('content')
<div class="p-4" style="background-color: #00000;"> <!-- Ubah warna latar belakang halaman -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div class="bg-green-300 p-4 rounded-lg shadow-md text-center hover:bg-green-400 transition duration-300">
            <h2 class="text-4xl">{{ $produkAman }}</h2>
            <p class="text-gray-800">Produk Aman</p>
        </div>
        <div class="bg-yellow-300 p-4 rounded-lg shadow-md text-center hover:bg-yellow-400 transition duration-300">
            <h2 class="text-4xl">{{ $produkMendekati }}</h2>
            <p class="text-gray-800">Produk Mendekati Kadaluarsa</p>
        </div>
        <div class="bg-red-300 p-4 rounded-lg shadow-md text-center hover:bg-green-400 transition duration-300">
            <h2 class="text-4xl">{{ $produkKedalursa }}</h2>
            <p class="text-gray-800">Produk Kedaluarsa</p>
        </div>
    </div>
</div>    
<div>
    <div class="mt-8">
        <canvas id="produkChart" style="background-color: #f3df60;"></canvas> <!-- Ubah warna latar belakang chart -->
    </div>
</div>

<style>
    /* Menggunakan font Inter */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('produkChart').getContext('2d');
        var produkChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($produk->pluck('nama_produk')),
                datasets: [{
                    label: 'Jumlah Produk',
                    data: @json($produk->pluck('jumlah')),
                    backgroundColor: '#444444',  // Ubah warna bar menjadi #444444
                    borderColor: '#444444',    // Ubah warna border bar menjadi #444444
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection