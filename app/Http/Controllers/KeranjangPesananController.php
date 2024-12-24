<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Order;
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

        // Menambahkan produk ke keranjang
        KeranjangPesanan::create([
            'produk_id' => $validated['productId'],
            'jumlah' => $validated['quantity'],
        ]);

        return response()->json(['success' => true]);
    }

    public function viewCart()
    {
        // Retrieve all cart items
        $keranjangPesanan = KeranjangPesanan::with('produk')->get();

        return view('keranjangPesanan', compact('keranjangPesanan'));
    }

    public function batalPesanan($id)
    {
        // Temukan item di keranjang berdasarkan ID
        $item = KeranjangPesanan::find($id);

        if ($item) {
            $item->delete(); // Hapus item
            return response()->json(['message' => 'Pesanan berhasil dibatalkan.'], 200);
        }

        return response()->json(['message' => 'Item tidak ditemukan.'], 404);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'productId' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $produk = Produk::find($validatedData['productId']);

        if ($produk->jumlah < $validatedData['quantity']) {
            return response()->json(['message' => 'Stok tidak mencukupi'], 400);
        }

        // Add product to cart
        $keranjang = new KeranjangPesanan();
        $keranjang->produk_id = $validatedData['productId'];
        $keranjang->jumlah = $validatedData['quantity'];
        $keranjang->save();

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang'], 200);
    }

    public function processAllOrders()
    {
        // Logic to process all orders
    }

    public function processOrderById($id)
    {
        // Logic to process a specific order by ID
    }

    public function approveOrder($id)
    {
        $order = KeranjangPesanan::find($id);
        if ($order) {
            $order->status = 'Approved';
            $order->save();
            return response()->json(['message' => 'Order approved successfully.']);
        }
        return response()->json(['message' => 'Order not found.'], 404);
    }

    public function rejectOrder($id)
    {
        $order = KeranjangPesanan::find($id);
        if ($order) {
            $order->status = 'Rejected';
            $order->save();
            return response()->json(['message' => 'Order rejected successfully.']);
        }
        return response()->json(['message' => 'Order not found.'], 404);
    }
}
