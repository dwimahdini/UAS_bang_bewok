@extends('layouts.sidebar')
@section('title', 'Beranda')

@section('content')
<header>
    <!-- Navbar -->
    <nav class="relative flex w-full items-center justify-between bg-white py-2 shadow-dark-mild dark:bg-body-dark lg:flex-wrap lg:justify-start lg:py-4" data-twe-navbar-ref>
      <div class="flex w-full flex-wrap items-center justify-between px-3">
        <div class="flex items-center"></div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->
    <div id="background" class="relative h-96 overflow-hidden bg-[url('{{ asset('img/bangBewok2.jpg') }}')] bg-cover bg-no-repeat p-12 text-center lg:h-screen">
      <div class="absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-teal-950/70 bg-fixed">
        <div class="flex h-full items-center justify-center">
          <div class="text-white">
            <h2 class="mb-4 text-4xl font-semibold">Susu Coklat dan Roti Kukus Bang Bewok</h2>
            <h4 class="mb-6 text-xl font-semibold">Selamat Datang</h4>
            <button id="scrollButton" class="mb-1 inline-block rounded border-2 border-neutral-50 px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-neutral-50 transition duration-150 ease-in-out hover:border-neutral-300 hover:text-neutral-200 focus:border-neutral-300 focus:text-neutral-200 focus:outline-none focus:ring-0 active:border-neutral-300 active:text-neutral-200 dark:hover:bg-neutral-600 dark:focus:bg-neutral-600">
              selengkapnya
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Background image -->
</header>

<!-- Horizontal Scroll Section -->
<div id="contentSection" class="flex flex-col h-screen w-full overflow-y-auto bg-gray-100">
  <div class="min-h-screen flex-none bg-white p-8">
    <br>
    <br>
    <!-- Horizontal Scroll Card Container -->
    <div class="flex space-x-4 overflow-x-auto p-4">
      <!-- Card 1 -->
      <div class="block rounded-lg bg-white shadow-secondary-1 dark:bg-surface-dark w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
          <a href="{{ route('pesanProduk') }}">
            <div class="flex justify-center items-center h-48 bg-gray-200">
              <i class="bx bx-archive-out text-6xl text-gray-700"></i>
            </div>
          </a>
          <div class="p-6 text-black">
            <h5 class="mb-2 text-xl font-medium leading-tight">Pesan Produk</h5>
            <p class="mb-4 text-base">
              Produk yang tersedia dan anda dapat memesan
            </p>
            <a href="{{ route('pesanProduk') }}">
              <button type="button" class="inline-block rounded bg-black px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-gray-700 hover:shadow-primary-2 focus:bg-gray-700 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong">
                klik disini
              </button>
            </a>
          </div>
        </div>

      <!-- Card 2 -->
      <div class="block rounded-lg bg-white shadow-secondary-1 dark:bg-surface-dark w-full md:w-1/2 lg:w-1/2 xl:w-1/2">
        <a href="{{ route('keranjangPesanan') }}">
          <div class="flex justify-center items-center h-48 bg-gray-200">
            <i class="bx bx-cart-alt text-6xl text-gray-700"></i>
          </div>
        </a>
        <div class="p-6 text-black">
          <h5 class="mb-2 text-xl font-medium leading-tight">Keranjang Pesanan</h5>
          <p class="mb-4 text-base">
            Semua pesanan anda tersimpan disini
          </p>
          <a href="{{ route('keranjangPesanan') }}">
            <button type="button" class="inline-block rounded bg-black px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-gray-700 hover:shadow-primary-2 focus:bg-gray-700 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong">
              klik disini
            </button>
          </a>
        </div>
    </div>
  </div>

<script>
  document.getElementById('scrollButton').addEventListener('click', function () {
    // Scroll vertikal ke konten
    document.getElementById('contentSection').scrollIntoView({ behavior: 'smooth' });

    // Sembunyikan gambar latar belakang setelah klik tombol
    document.getElementById('background').classList.add('hidden');
  });

  // Mengaktifkan scroll normal pada konten
  document.getElementById('contentSection').addEventListener('wheel', function () {
    document.getElementById('background').classList.remove('hidden');
  });
</script>
@endsection