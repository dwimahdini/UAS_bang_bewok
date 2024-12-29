<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

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
            return $pesanan->produk ? $pesanan->produk->harga : 0;
        });
        return view('laporan', compact('data', 'totalProduk','totalHarga'));
    }

    public function print(Request $req)
    {
        $startDate = $req->input('from_date');
        $endDate = $req->input('to_date');

        $data = RiwayatPesanan::with(['status', 'produk']);
        if ($startDate && $endDate) {
            $data->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $data->get();

        $totalProduk = $data->sum('jumlah');
        $totalHarga = $data->sum(function ($pesanan) {
            return $pesanan->produk ? $pesanan->produk->harga : 0;
        });

        $pdf = FacadePdf::loadView('pdf.printreport', compact('data', 'totalProduk', 'totalHarga'));
        return $pdf->download('laporan.pdf');
    }
}