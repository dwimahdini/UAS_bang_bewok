<?php

namespace App\Http\Controllers;

use App\Models\KeranjangPesanan;
use App\Models\Status;
use Illuminate\Http\Request;

class PesananMasukController extends Controller
{
    public function index()
    {
        $keranjang = KeranjangPesanan::with('produk', 'status')->get();
        $status = Status::all();
        return view('pesananMasuk', compact('keranjang', 'status'));
    }

    public function edit($id)
    {
        $keranjang = KeranjangPesanan::with('produk', 'status')->where('id', $id)->get();
        return response()->json($keranjang);
    }

    public function update(Request $request, $id)
    {
        $pesanan = KeranjangPesanan::findOrFail($id);
        // Validasi data
        $validatedData = $request->validate([
            'id_status' => 'required'
        ]);

        // Update data di database
        $pesanan->update([
            'id_status' => $validatedData['id_status']
        ]);

        return redirect()->route('pesananMasuk.view')->with('success', 'Status berhasil diperbarui.');
    }
}
