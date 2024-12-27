<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $req){
        $startDate = $req->input('from_date');
        $endDate = $req->input('to_date');

        $data = RiwayatPesanan::with(['status','produk']);
        if ($startDate && $endDate) {
            $data->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $data->get();

        $totalProduk = RiwayatPesanan::sum('jumlah');
        $totalHarga = RiwayatPesanan::with('produk')->get()->sum(function ($pesanan) {
            return $pesanan->produk->harga;
        });
        return view('laporan', compact('data', 'totalProduk','totalHarga'));
    }
}
