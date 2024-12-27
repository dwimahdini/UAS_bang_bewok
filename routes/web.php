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
Route::get('/inventori', [ProdukController::class, 'index'])->name('inventori')->middleware('auth');
// Route untuk mengambil produk di database lalu ditampilkan
Route::get('/inventori', [ProdukController::class, 'index'])->name('produk.index')->middleware('auth');
// Route untuk menyimpan produk ke database
Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store')->middleware('auth');
// Route untuk mengedit produk
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update')->middleware('auth');
// Route menghapus produk
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy')->middleware('auth');
Route::get('/inventori', [ProdukController::class, 'index'])->name('inventori')->middleware('auth');

Route::get('/produk/{id}/edit', [ProdukController::class, 'show'])->middleware('auth');
Route::put('/produk/update/{id}', [ProdukController::class, 'updateProduk'])->name('updateProduk')->middleware('auth');

// ROUTE UNTUK STAFF
Route::get('/staf', [StaffController::class, 'index'])->middleware('auth');
Route::post('/staff', [StaffController::class, 'store'])->name('staff.store')->middleware('auth');
Route::get('/staf', [StaffController::class, 'index'])->name('staff.index')->middleware('auth');
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy')->middleware('auth');
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit')->middleware('auth');
Route::put('/staff/{id}', [StaffController::class, 'update'])->name('staff.update')->middleware('auth');

// ROUTE UNTUK CABANG
Route::get('/cabang', [CabangController::class, 'index'])->name('cabang.index')->middleware('auth');
Route::post('/cabangs', [CabangController::class, 'store'])->name('cabangs.store')->middleware('auth');
Route::delete('/cabangs/{id}', [CabangController::class, 'destroy'])->name('cabangs.destroy')->middleware('auth');
Route::get('/cabangs', [CabangController::class, 'index'])->name('cabangs.index');

// ROUTE UNTUK PESANAN MASUK
Route::get('/pesananMasuk', [PesananMasukController::class, 'index'])->name('pesananMasuk.view')->middleware('auth');
Route::get('/pesananMasuk/edit/{id}', [PesananMasukController::class, 'edit'])->middleware('auth');;
Route::put('/pesananMasuk/update/{id}', [PesananMasukController::class, 'update'])->middleware('auth');;

// ROUTE UNTUK TABLE MENAMPUNG AKUN
Route::get('/penggunaakun', [PenggunaAkunController::class, 'index'])->name('penggunaakun.index')->middleware('auth');
Route::post('/penggunaakun', [PenggunaAkunController::class, 'store'])->name('penggunaakun.store')->middleware('auth');

// ROUTE UNTUK LANDING PAGE
Route::get('/', function () { return view('welcome');});

// ROUTE UNTUK BERANDA
Route::get('/beranda', [ProdukController::class, 'berandaAdmin'])->name('beranda')->middleware('auth');

//beranda staf
Route::get('/berandaStaf', function () { return view('berandaStaf');})->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'autentic']);
Route::get('/login', function () { return view('login');});

//laporan

Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

//landing page
Route::get('/', function () { return view('welcome');});

Route::resource('produk', ProdukController::class);


Route::middleware(['auth'])->group( function (){
    Route::get('/laporan', [LaporanController::class,'index'])->name('laporan.index');
    Route::post('/laporan/store', [LaporanController::class, 'store'])->name('laporan.store');
});

// ROUTE UNTUK LAPORAN


// Route untuk menyimpan pengguna baru
Route::post('/users/store', [PenggunaAkunController::class, 'store'])->name('users.store');

// ROUTE UNTUK PENGGUNA AKUN
Route::get('/penggunaakun', [PenggunaAkunController::class, 'index']);


// ROUTE BARU UNTUK PESAN PRODUK
Route::get('/pesanProduk', [PesanProdukController::class, 'index'])->name('pesan.produk')->middleware('auth');

// Route untuk menambahkan produk ke keranjang
Route::post('/keranjang', [KeranjangPesananController::class, 'store']);

// Route untuk melihat keranjang
Route::get('/keranjangPesanan', [KeranjangPesananController::class, 'viewCart'])->name('keranjang.view')->middleware('auth');

Route::post('/produk/batal/{id}', [ProdukController::class, 'batal'])->name('produk.batal');

Route::post('/keranjangPesanan', [ProdukController::class, 'tambahKeKeranjang']);

Route::post('/keranjangPesanan', [KeranjangPesananController::class, 'store'])->name('keranjang.store')->middleware('auth');
Route::get('/produk/{id}/show', [ProdukController::class, 'edit'])->name('produk.edit')->middleware('auth');
Route::patch('/produk/{id}/update', [ProdukController::class, 'update'])->middleware('auth');

Route::delete('/keranjang/{id}/batal', [KeranjangPesananController::class, 'batalPesanan']);

Route::post('/process-order', [KeranjangPesananController::class, 'processAllOrders']);

Route::post('/keranjang/{id}/process', [KeranjangPesananController::class, 'processOrder']);
Route::post('/keranjang/{id}/approve', [KeranjangPesananController::class, 'approveOrder']);
Route::post('/keranjang/{id}/reject', [KeranjangPesananController::class, 'rejectOrder']);

Route::post('/pesan-produk/tambah-ke-keranjang', [PesanProdukController::class, 'tambahKeKeranjang']);

Route::post('/process-order', [KeranjangPesananController::class, 'processAllOrders']);
Route::post('/terima-pesanan/{id}', [KeranjangPesananController::class, 'approveOrder']);
Route::post('/tolak-pesanan/{id}', [KeranjangPesananController::class, 'rejectOrder']);

Route::post('/keranjang/update-status', [PesananMasukController::class, 'updateStatus']);

Route::post('/keranjang/process', [KeranjangPesananController::class, 'processOrders']);

Route::get('/cart', [KeranjangPesananController::class, 'viewCart']);

Route::post('/keranjang/process', [KeranjangPesananController::class, 'processOrders'])->middleware('auth');
Route::post('/keranjang/approve', [KeranjangPesananController::class, 'approve'])->name('keranjang.approve')->middleware('auth');
Route::post('/keranjang/reject', [KeranjangPesananController::class, 'reject'])->name('keranjang.reject')->middleware('auth');

Route::get('/pesananMasuk', [PesananMasukController::class, 'index']);
Route::post('/pesananMasuk/updateStatus', [PesananMasukController::class, 'updateStatus'])->middleware('auth');
Route::post('/pesananMasuk/processOrders', [PesananMasukController::class, 'processOrders'])->middleware('auth');
Route::post('/pesananMasuk/approveOrders', [PesananMasukController::class, 'approveOrders'])->middleware('auth');
Route::post('/pesananMasuk/rejectOrders', [KeranjangPesananController::class, 'rejectOrders'])->middleware('auth');

Route::get('/keranjangPesanan', [KeranjangPesananController::class, 'index'])->middleware('auth');
Route::post('/keranjangPesanan/addToCart', [KeranjangPesananController::class, 'addToCart'])->middleware('auth');
Route::post('/keranjangPesanan/processAllOrders', [KeranjangPesananController::class, 'processAllOrders'])->middleware('auth');
Route::post('/keranjangPesanan/processOrder/{id}', [KeranjangPesananController::class, 'processOrder'])->middleware('auth');
Route::post('/keranjangPesanan/approveOrder/{id}', [KeranjangPesananController::class, 'approveOrder'])->middleware('auth');
Route::post('/keranjangPesanan/rejectOrder/{id}', [KeranjangPesananController::class, 'rejectOrder'])->middleware('auth');
Route::delete('/keranjangPesanan/batalPesanan/{id}', [KeranjangPesananController::class, 'batalPesanan'])->middleware('auth');

Route::post('/pesananMasuk/terimaPesanan', [PesananMasukController::class, 'approveOrders'])->middleware('auth');
Route::post('/pesananMasuk/tolakPesanan', [PesananMasukController::class, 'rejectOrders'])->middleware('auth');

Route::post('/updateStatus', [PesananMasukController::class, 'updateStatus'])->middleware('auth');

Route::get('/debug-cart-status', function () {
    return KeranjangPesanan::all()->middleware('auth');
});
