<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\KeranjangPesanan;

class KeranjangPesananController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'productId' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        KeranjangPesanan::create([
            'produk_id' => $validated['productId'],
            'jumlah' => $validated['quantity'],
        ]);

        return response()->json(['success' => true]);
    }

    public function viewCart()
    {
        $keranjangPesanan = KeranjangPesanan::with('produk')->get();
        return view('keranjangPesanan', compact('keranjangPesanan'));
    }

    public function batalPesanan($id)
    {
        $item = KeranjangPesanan::find($id);

        if ($item) {
            $item->delete(); // Hapus item
            return response()->json(['message' => 'Pesanan berhasil dibatalkan.'], 200);
        }

        return response()->json(['message' => 'Item tidak ditemukan.'], 404);
    }

    // Process all orders from the cart
    public function processAllOrders()
    {
        $keranjangPesanan = KeranjangPesanan::with('produk')->get();
        return response()->json(['message' => 'All orders processed successfully.'], 200);
    }
    public function approveOrder($id)
    {
        // Logic to approve a specific order by ID
    }

    // Reject an order (if needed)
    public function rejectOrder($id)
    {
        // Logic to reject a specific order by ID
    }
}
