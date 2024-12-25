<?php

namespace App\Http\Controllers;

use App\Models\KeranjangPesanan;
use Illuminate\Http\Request;

class PesananMasukController extends Controller
{
    public function index()
    {
        $keranjangPesanan = KeranjangPesanan::with('produk')->get();
        return view('pesananMasuk', compact('keranjangPesanan'));
    }
}
