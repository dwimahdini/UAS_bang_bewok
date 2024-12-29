<?php

use App\Http\Controllers\PesananMasukController;
use App\Models\KeranjangPesanan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PenggunaAkunController;
use App\Http\Controllers\PesanProdukController;
use App\Http\Controllers\KeranjangPesananController;
use App\Http\Controllers\OrderController;

// ROUTE UNTUK INVENTORI
// Menampilkan halaman inventori
Route::get('/inventori', [ProdukController::class, 'index'])->name('inventori')->middleware('auth');
// Menampilkan daftar produk
Route::get('/inventori', [ProdukController::class, 'index'])->name('produk.index')->middleware('auth');
// Menyimpan produk baru
Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store')->middleware('auth');
// Mengupdate produk yang sudah ada
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update')->middleware('auth');
// Menghapus produk
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy')->middleware('auth');
// Menampilkan halaman untuk mengedit produk
Route::get('/produk/{id}/edit', [ProdukController::class, 'show'])->middleware('auth');
// Mengupdate produk dengan ID tertentu
Route::put('/produk/update/{id}', [ProdukController::class, 'updateProduk'])->name('updateProduk')->middleware('auth');
// Menambahkan resource routes untuk produk
Route::resource('produk', ProdukController::class)->middleware('auth');
// Membatalkan produk
Route::post('/produk/batal/{id}', [ProdukController::class, 'batal'])->name('produk.batal');
// Menampilkan halaman edit produk
Route::get('/produk/{id}/show', [ProdukController::class, 'edit'])->name('produk.edit')->middleware('auth');
// Mengupdate produk dengan metode patch
Route::patch('/produk/{id}/update', [ProdukController::class, 'update'])->middleware('auth');

// ROUTE UNTUK STAFF
// Menampilkan halaman daftar staff
Route::get('/staf', [StaffController::class, 'index'])->middleware('auth');
// Menyimpan staff baru
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store')->middleware('auth');
// Menampilkan daftar staff
Route::get('/staf', [StaffController::class, 'index'])->name('staff.index')->middleware('auth');
// Menghapus staff dengan ID tertentu
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy')->middleware('auth');
// Menampilkan halaman edit staff
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit')->middleware('auth');
// Mengupdate staff dengan ID tertentu
Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update')->middleware('auth');

// ROUTE UNTUK CABANG
// Menampilkan halaman daftar cabang
Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index')->middleware('auth');
// Menyimpan cabang baru
Route::post('/cabangs', [CabangController::class, 'store'])->name('cabangs.store')->middleware('auth');
// Menghapus cabang dengan ID tertentu
Route::delete('/cabangs/{id}', [CabangController::class, 'destroy'])->name('cabangs.destroy')->middleware('auth');
// Menampilkan daftar cabang
Route::get('/cabangs', [CabangController::class, 'index'])->name('cabangs.index');

// ROUTE UNTUK PESANAN MASUK
// Menampilkan halaman daftar pesanan masuk
Route::get('/pesananMasuk', [PesananMasukController::class, 'index'])->name('pesananMasuk.view')->middleware('auth');
// Menampilkan halaman edit pesanan masuk
Route::get('/pesananMasuk/edit/{id}', [PesananMasukController::class, 'edit'])->middleware('auth');
// Mengupdate pesanan masuk dengan ID tertentu
Route::put('/pesananMasuk/update/{id}', [PesananMasukController::class, 'update'])->middleware('auth');
// Mengupdate status pesanan masuk
Route::post('/pesananMasuk/updateStatus', [PesananMasukController::class, 'updateStatus'])->middleware('auth');
// Memproses pesanan masuk
Route::post('/pesananMasuk/processOrders', [PesananMasukController::class, 'processOrders'])->middleware('auth');
// Menerima pesanan masuk
Route::post('/pesananMasuk/approveOrders', [PesananMasukController::class, 'approveOrders'])->middleware('auth');
// Menolak pesanan masuk
Route::post('/pesananMasuk/rejectOrders', [KeranjangPesananController::class, 'rejectOrders'])->middleware('auth');
// Menerima pesanan masuk
Route::post('/pesananMasuk/terimaPesanan', [PesananMasukController::class, 'approveOrders'])->middleware('auth');
// Menolak pesanan masuk
Route::post('/pesananMasuk/tolakPesanan', [PesananMasukController::class, 'rejectOrders'])->middleware('auth');
// Mengupdate status pesanan
Route::post('/updateStatus', [PesananMasukController::class, 'updateStatus'])->middleware('auth');

// ROUTE UNTUK TABLE MENAMPUNG AKUN
// Menampilkan halaman daftar pengguna akun
Route::get('/penggunaakun', [PenggunaAkunController::class, 'index'])->name('penggunaakun.index')->middleware('auth');
// Menyimpan pengguna akun baru
Route::post('/penggunaakun', [PenggunaAkunController::class, 'store'])->name('penggunaakun.store')->middleware('auth');
// Menampilkan daftar pengguna akun
Route::get('/penggunaakun', [PenggunaAkunController::class, 'index']);
// Menyimpan pengguna baru
Route::post('/users/store', [PenggunaAkunController::class, 'store'])->name('users.store');

// ROUTE UNTUK LANDING PAGE
// Menampilkan halaman welcome
Route::get('/', function () { return view('welcome'); });

// ROUTE UNTUK BERANDA
// Menampilkan halaman beranda admin
Route::get('/beranda', [ProdukController::class, 'berandaAdmin'])->name('beranda')->middleware('auth');
// Menampilkan halaman beranda staff
Route::get('/berandaStaf', function () { return view('berandaStaf'); })->middleware('auth');

// ROUTE UNTUK LOGIN DAN LOGOUT
// Menampilkan halaman login
Route::get('/login', [LoginController::class, 'showLoginForm']);
// Proses login
Route::post('/login', [LoginController::class, 'autentic']);
// Menampilkan halaman login
Route::get('/login', function () { return view('login'); });
// Proses logout
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');
// ROUTE UNTUK LAPORAN
Route::middleware(['auth'])->group(function () {
    // Menampilkan halaman laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    // Menyimpan laporan baru
    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
});
// Mencetak laporan
Route::get('/laporan/print', [LaporanController::class, 'print'])->name('laporan.print');

// ROUTE UNTUK PESAN PRODUK DAN KERANJANG PESANAN
// Menampilkan halaman pesan produk
Route::get('/pesanProduk', [PesanProdukController::class, 'index'])->name('pesan.produk')->middleware('auth');
// Menambahkan produk ke keranjang
Route::post('/keranjang', [KeranjangPesananController::class, 'store']);
// Menampilkan halaman keranjang pesanan
Route::get('/keranjangPesanan', [KeranjangPesananController::class, 'viewCart'])->name('keranjang.view')->middleware('auth');
// Menambahkan produk ke keranjang
Route::post('/keranjangPesanan', [ProdukController::class, 'tambahKeKeranjang']);
// Menyimpan keranjang pesanan
Route::post('/keranjangPesanan', [KeranjangPesananController::class, 'store'])->name('keranjang.store')->middleware('auth');
// Membatalkan pesanan di keranjang
Route::delete('/keranjang/{id}/batal', [KeranjangPesananController::class, 'batalPesanan']);
// Memproses semua pesanan di keranjang
Route::post('/process-order', [KeranjangPesananController::class, 'processAllOrders']);
// Memproses pesanan dengan ID tertentu di keranjang
Route::post('/keranjang/{id}/process', [KeranjangPesananController::class, 'processOrder']);
// Menyetujui pesanan dengan ID tertentu di keranjang
Route::post('/keranjang/{id}/approve', [KeranjangPesananController::class, 'approveOrder']);
// Menolak pesanan dengan ID tertentu di keranjang
Route::post('/keranjang/{id}/reject', [KeranjangPesananController::class, 'rejectOrder']);
// Menambahkan produk ke keranjang
Route::post('/pesan-produk/tambah-ke-keranjang', [PesanProdukController::class, 'tambahKeKeranjang']);
// Mengupdate status keranjang
Route::post('/keranjang/update-status', [PesananMasukController::class, 'updateStatus']);
// Memproses semua pesanan di keranjang
Route::post('/keranjang/process', [KeranjangPesananController::class, 'processOrders']);
// Menyetujui pesanan di keranjang
Route::post('/keranjang/approve', [KeranjangPesananController::class, 'approve'])->name('keranjang.approve')->middleware('auth');
// Menolak pesanan di keranjang
Route::post('/keranjang/reject', [KeranjangPesananController::class, 'reject'])->name('keranjang.reject')->middleware('auth');
// Menampilkan halaman keranjang pesanan
Route::get('/keranjangPesanan', [KeranjangPesananController::class, 'index'])->middleware('auth');
// Menambahkan produk ke keranjang
Route::post('/keranjangPesanan/addToCart', [KeranjangPesananController::class, 'addToCart'])->middleware('auth');
// Memproses semua pesanan di keranjang
Route::post('/keranjangPesanan/processAllOrders', [KeranjangPesananController::class, 'processAllOrders'])->middleware('auth');
// Memproses pesanan dengan ID tertentu di keranjang
Route::post('/keranjangPesanan/processOrder/{id}', [KeranjangPesananController::class, 'processOrder'])->middleware('auth');
// Menyetujui pesanan dengan ID tertentu di keranjang
Route::post('/keranjangPesanan/approveOrder/{id}', [KeranjangPesananController::class, 'approveOrder'])->middleware('auth');
// Menolak pesanan dengan ID tertentu di keranjang
Route::post('/keranjangPesanan/rejectOrder/{id}', [KeranjangPesananController::class, 'rejectOrder'])->middleware('auth');
// Membatalkan pesanan dengan ID tertentu di keranjang
Route::delete('/keranjangPesanan/batalPesanan/{id}', [KeranjangPesananController::class, 'batalPesanan'])->middleware('auth');
// Menampilkan halaman keranjang
Route::get('/cart', [KeranjangPesananController::class, 'viewCart']);

// DEBUG ROUTES
// Menampilkan status keranjang untuk debugging
Route::get('/debug-cart-status', function () {
    return KeranjangPesanan::all()->middleware('auth');
});